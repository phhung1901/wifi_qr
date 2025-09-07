<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;

class OptimizeBlogDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:optimize {--analyze : Analyze tables} {--repair : Repair tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize blog database tables and indexes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting blog database optimization...');

        if ($this->option('analyze')) {
            $this->analyzeTables();
        }

        if ($this->option('repair')) {
            $this->repairTables();
        }

        $this->optimizeTables();
        $this->updateStatistics();
        $this->cleanupOrphanedRecords();

        $this->info('✅ Blog database optimization completed!');
        return Command::SUCCESS;
    }

    private function analyzeTables()
    {
        $this->info('📊 Analyzing tables...');

        $tables = [
            'languages', 'categories', 'category_translations',
            'tags', 'tag_translations', 'blog_groups', 'blogs',
            'blog_tags', 'blog_meta'
        ];

        foreach ($tables as $table) {
            $this->line("Analyzing table: {$table}");
            DB::statement("ANALYZE TABLE {$table}");
        }
    }

    private function repairTables()
    {
        $this->info('🔧 Repairing tables...');

        $tables = [
            'languages', 'categories', 'category_translations',
            'tags', 'tag_translations', 'blog_groups', 'blogs',
            'blog_tags', 'blog_meta'
        ];

        foreach ($tables as $table) {
            $this->line("Repairing table: {$table}");
            DB::statement("REPAIR TABLE {$table}");
        }
    }

    private function optimizeTables()
    {
        $this->info('⚡ Optimizing tables...');

        $tables = [
            'languages', 'categories', 'category_translations',
            'tags', 'tag_translations', 'blog_groups', 'blogs',
            'blog_tags', 'blog_meta'
        ];

        foreach ($tables as $table) {
            $this->line("Optimizing table: {$table}");
            DB::statement("OPTIMIZE TABLE {$table}");
        }
    }

    private function updateStatistics()
    {
        $this->info('📈 Updating blog statistics...');

        // Update comment counts
        DB::statement("
            UPDATE blogs
            SET comment_count = (
                SELECT COUNT(*)
                FROM blog_meta
                WHERE blog_meta.blog_id = blogs.id
                AND blog_meta.meta_key = 'comment_count'
            )
        ");

        $this->line('Statistics updated successfully');
    }

    private function cleanupOrphanedRecords()
    {
        $this->info('🧹 Cleaning up orphaned records...');

        // Clean up orphaned blog_tags
        $orphanedBlogTags = DB::table('blog_tags')
            ->leftJoin('blogs', 'blog_tags.blog_id', '=', 'blogs.id')
            ->leftJoin('tags', 'blog_tags.tag_id', '=', 'tags.id')
            ->whereNull('blogs.id')
            ->orWhereNull('tags.id')
            ->count();

        if ($orphanedBlogTags > 0) {
            DB::table('blog_tags')
                ->leftJoin('blogs', 'blog_tags.blog_id', '=', 'blogs.id')
                ->leftJoin('tags', 'blog_tags.tag_id', '=', 'tags.id')
                ->where(function($query) {
                    $query->whereNull('blogs.id')->orWhereNull('tags.id');
                })
                ->delete();

            $this->line("Cleaned up {$orphanedBlogTags} orphaned blog_tags records");
        }

        // Clean up orphaned blog_meta
        $orphanedBlogMeta = DB::table('blog_meta')
            ->leftJoin('blogs', 'blog_meta.blog_id', '=', 'blogs.id')
            ->whereNull('blogs.id')
            ->count();

        if ($orphanedBlogMeta > 0) {
            DB::table('blog_meta')
                ->leftJoin('blogs', 'blog_meta.blog_id', '=', 'blogs.id')
                ->whereNull('blogs.id')
                ->delete();

            $this->line("Cleaned up {$orphanedBlogMeta} orphaned blog_meta records");
        }

        $this->line('Cleanup completed');
    }
}

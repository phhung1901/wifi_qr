<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add fulltext indexes for search functionality
        DB::statement('ALTER TABLE blogs ADD FULLTEXT(title, excerpt, content)');
        DB::statement('ALTER TABLE category_translations ADD FULLTEXT(name, description)');
        DB::statement('ALTER TABLE tag_translations ADD FULLTEXT(name, description)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop fulltext indexes
        DB::statement('ALTER TABLE blogs DROP INDEX title');
        DB::statement('ALTER TABLE category_translations DROP INDEX name');
        DB::statement('ALTER TABLE tag_translations DROP INDEX name');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_group_id')->comment('ID nhóm bài viết đa ngôn ngữ');
            $table->string('language_code', 10)->comment('Mã ngôn ngữ bài viết');
            $table->unsignedBigInteger('category_id')->comment('ID danh mục');

            // Nội dung cơ bản
            $table->string('title', 500)->comment('Tiêu đề bài viết');
            $table->string('slug')->comment('URL slug');
            $table->text('excerpt')->nullable()->comment('Tóm tắt bài viết');
            $table->longText('content')->comment('Nội dung bài viết');

            // Hình ảnh
            $table->string('featured_image', 500)->nullable()->comment('Ảnh đại diện');
            $table->string('featured_image_alt')->nullable()->comment('Alt text cho ảnh đại diện');
            $table->json('gallery')->nullable()->comment('Album ảnh bổ sung');

            // SEO
            $table->string('seo_title')->nullable()->comment('SEO Title');
            $table->text('seo_description')->nullable()->comment('SEO Description');
            $table->string('seo_keywords', 500)->nullable()->comment('SEO Keywords');
            $table->string('seo_canonical_url', 500)->nullable()->comment('Canonical URL');

            // Trạng thái và thời gian
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->comment('Trạng thái bài viết');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản');
            $table->timestamp('scheduled_at')->nullable()->comment('Thời gian lên lịch xuất bản');

            // Thống kê
            $table->integer('view_count')->default(0)->comment('Lượt xem');
            $table->integer('like_count')->default(0)->comment('Lượt thích');
            $table->integer('comment_count')->default(0)->comment('Số bình luận');

            // Cấu hình
            $table->boolean('allow_comments')->default(true)->comment('Cho phép bình luận');
            $table->boolean('is_featured')->default(false)->comment('Bài viết nổi bật');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');

            // Thông tin tác giả
            $table->unsignedBigInteger('author_id')->nullable()->comment('ID tác giả');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('blog_group_id')->references('id')->on('blog_groups')->onDelete('cascade');
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');

            // Unique constraints
            $table->unique(['blog_group_id', 'language_code'], 'unique_group_language');
            $table->unique(['language_code', 'slug'], 'unique_language_slug');

            // Indexes
            $table->index('blog_group_id');
            $table->index('language_code');
            $table->index('category_id');
            $table->index('status');
            $table->index('published_at');
            $table->index('is_featured');
            $table->index('slug');
            $table->index('author_id');
            $table->index(['status', 'published_at']);
            $table->index(['language_code', 'status', 'published_at']);
            $table->index(['language_code', 'category_id', 'status', 'published_at']);
            $table->index(['is_featured', 'status', 'published_at']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

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
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment('ID danh mục');
            $table->string('language_code', 10)->comment('Mã ngôn ngữ');
            $table->string('name')->comment('Tên danh mục');
            $table->text('description')->nullable()->comment('Mô tả danh mục');
            $table->string('seo_title')->nullable()->comment('SEO Title');
            $table->text('seo_description')->nullable()->comment('SEO Description');
            $table->string('seo_keywords', 500)->nullable()->comment('SEO Keywords');
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
            
            // Unique constraint
            $table->unique(['category_id', 'language_code'], 'unique_category_language');
            
            // Indexes
            $table->index('category_id');
            $table->index('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};

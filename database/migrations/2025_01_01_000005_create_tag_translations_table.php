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
        Schema::create('tag_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id')->comment('ID tag');
            $table->string('language_code', 10)->comment('Mã ngôn ngữ');
            $table->string('name')->comment('Tên tag');
            $table->text('description')->nullable()->comment('Mô tả tag');
            $table->string('seo_title')->nullable()->comment('SEO Title');
            $table->text('seo_description')->nullable()->comment('SEO Description');
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
            
            // Unique constraint
            $table->unique(['tag_id', 'language_code'], 'unique_tag_language');
            
            // Indexes
            $table->index('tag_id');
            $table->index('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_translations');
    }
};

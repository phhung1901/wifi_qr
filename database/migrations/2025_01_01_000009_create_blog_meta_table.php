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
        Schema::create('blog_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id')->comment('ID bài viết');
            $table->string('meta_key')->comment('Khóa meta');
            $table->longText('meta_value')->nullable()->comment('Giá trị meta');
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            
            // Unique constraint
            $table->unique(['blog_id', 'meta_key'], 'unique_blog_meta');
            
            // Indexes
            $table->index('blog_id');
            $table->index('meta_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_meta');
    }
};

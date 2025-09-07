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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Danh mục cha (hỗ trợ danh mục con)');
            $table->string('slug')->comment('URL slug cho category');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            $table->boolean('is_active')->default(true)->comment('Kích hoạt danh mục');
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            
            // Indexes
            $table->index('parent_id');
            $table->index('slug');
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Mã ngôn ngữ (vi, en, ja, ko, etc.)');
            $table->string('name', 100)->comment('Tên ngôn ngữ (Tiếng Việt, English, etc.)');
            $table->string('native_name', 100)->comment('Tên ngôn ngữ gốc');
            $table->boolean('is_default')->default(false)->comment('Ngôn ngữ mặc định');
            $table->boolean('is_active')->default(true)->comment('Kích hoạt ngôn ngữ');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};

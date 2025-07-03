<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // Track unique users
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('download_type')->default('png'); // png, pdf, svg
            $table->string('wifi_ssid')->nullable(); // WiFi name for analytics
            $table->boolean('has_logo')->default(false);
            $table->boolean('has_custom_colors')->default(false);
            $table->string('language', 5)->default('en'); // User language
            $table->string('country', 2)->nullable(); // User country
            $table->string('referrer')->nullable(); // Where they came from
            $table->timestamps();

            // Indexes for performance
            $table->index(['created_at']);
            $table->index(['session_id']);
            $table->index(['download_type']);
            $table->index(['language']);
            $table->index(['country']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_downloads');
    }
};

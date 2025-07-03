<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g., 'total_qr_generated'
            $table->bigInteger('value')->default(0); // The counter value
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
        });

        // Insert initial data
        DB::table('statistics')->insert([
            [
                'key' => 'total_qr_generated',
                'value' => 1000000, // Start from 1 million for credibility
                'last_updated' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
};

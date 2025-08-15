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
        Schema::create('multi_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name');
            $table->string('country_code');
            $table->string('currency_code');
            $table->string('currency_icon');
            $table->string('is_default')->defualt('no');
            $table->float('currency_rate');
            $table->string('currency_position')->default('before_price');
            $table->string('status')->defualt('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_currencies');
    }
};

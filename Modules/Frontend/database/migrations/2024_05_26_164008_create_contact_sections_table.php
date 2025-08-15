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
        Schema::create('contact_sections', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable(); 
            $table->string('phone_one')->nullable(); 
            $table->string('phone_two')->nullable(); 
            $table->string('email_one')->nullable(); 
            $table->string('email_two')->nullable(); 
            $table->text('map')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_sections');
    }
};

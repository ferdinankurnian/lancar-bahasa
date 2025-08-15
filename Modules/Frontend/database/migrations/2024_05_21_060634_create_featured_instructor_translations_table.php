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
        Schema::create('featured_instructor_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('featured_instructor_section_id')->default(1);
            $table->string('lang_code');   
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('button_text')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_instructor_translations');
    }
};

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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_item_id');
            $table->foreignId('instructor_id');
            $table->foreignId('chapter_id');
            $table->foreignId('course_id');
            $table->string('title');
            $table->string('time')->nullable();
            $table->string('attempt')->nullable();
            $table->string('pass_mark')->nullable();
            $table->string('total_mark')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};

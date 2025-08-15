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
        Schema::create('course_live_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('course_chapter_lessons')->cascadeOnDelete();
            $table->string('start_time')->nullable();
            $table->enum('type', ['zoom','jitsi'])->default('zoom');
            $table->string('meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->string('join_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_live_classes');
    }
};

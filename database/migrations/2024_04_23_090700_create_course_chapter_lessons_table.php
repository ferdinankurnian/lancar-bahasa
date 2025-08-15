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
        Schema::create('course_chapter_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('instructor_id')->constrained('users');
            $table->foreignId('course_id');
            $table->foreignId('chapter_id')->constrained('course_chapters');
            $table->foreignId('chapter_item_id')->constrained('course_chapter_items');
            $table->text('file_path')->nullable();
            $table->enum('storage', ['upload','youtube','vimeo','external_link','google_drive','iframe','aws'])->default('upload');
            $table->string('volume')->nullable();
            $table->string('duration')->nullable();
            $table->enum('file_type', ['video','audio','pdf','txt','docx','iframe','image','file','other'])->default('video');
            $table->boolean('downloadable')->default(1);
            $table->integer('order')->nullable();
            $table->boolean('is_free')->default(0)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_chapter_lessons');
    }
};

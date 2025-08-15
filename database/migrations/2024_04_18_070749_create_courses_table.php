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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id');
            $table->foreignId('category_id')->nullable();
            $table->enum('type', ['course', 'webinar'])->default('course');
            $table->string('title');
            $table->string('slug');
            $table->string('seo_description')->nullable();
            $table->date('start_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('timezone')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('demo_video_storage', ['upload', 'youtube', 'vimeo', 'external_link', 'aws'])->default('upload');
            $table->text('demo_video_source')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity')->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->nullable();
            $table->boolean('certificate')->default(0);
            $table->boolean('downloadable')->default(0);
            $table->boolean('partner_instructor')->default(0);
            $table->boolean('qna')->default(0);
            $table->text('message_for_reviewer')->nullable();
            $table->enum('status', ['active', 'is_draft', 'inactive'])->default('is_draft');
            $table->enum('is_approved', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

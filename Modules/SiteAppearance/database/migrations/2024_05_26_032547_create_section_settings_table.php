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
        Schema::create('section_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('hero_section')->default(0);
            $table->boolean('top_category_section')->default(0);
            $table->boolean('brands_section')->default(0);
            $table->boolean('about_section')->default(0);
            $table->boolean('featured_course_section')->default(0);
            $table->boolean('news_letter_section')->default(0);
            $table->boolean('featured_instructor_section')->default(0);
            $table->boolean('counter_section')->default(0);
            $table->boolean('faq_section')->default(0);
            $table->boolean('our_features_section')->default(0);
            $table->boolean('testimonial_section')->default(0);
            $table->boolean('banner_section')->default(0);
            $table->boolean('latest_blog_section')->default(0);
            $table->boolean('blog_page')->default(0);
            $table->boolean('about_page')->default(0);
            $table->boolean('contact_page')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_settings');
    }
};

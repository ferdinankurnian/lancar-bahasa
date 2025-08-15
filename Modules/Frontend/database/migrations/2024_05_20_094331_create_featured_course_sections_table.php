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
        Schema::create('featured_course_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('all_category')->nullable();
            $table->text('all_category_ids')->nullable();
            $table->boolean('all_category_status')->default(1);

            $table->integer('category_one')->nullable();
            $table->text('category_one_ids')->nullable();
            $table->boolean('category_one_status')->default(1);

            $table->integer('category_two')->nullable();
            $table->text('category_two_ids')->nullable();
            $table->boolean('category_two_status')->default(1);

            $table->integer('category_three')->nullable();
            $table->text('category_three_ids')->nullable();
            $table->boolean('category_three_status')->default(1);

            $table->integer('category_four')->nullable();
            $table->text('category_four_ids')->nullable();
            $table->boolean('category_four_status')->default(1);

            $table->integer('category_five')->nullable();
            $table->text('category_five_ids')->nullable();
            $table->boolean('category_five_status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_course_sections');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Blog\app\Models\BlogCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BlogCategory::class)->constrained('blog_categories');
            $table->string('lang_code');
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category_translations');
    }
};

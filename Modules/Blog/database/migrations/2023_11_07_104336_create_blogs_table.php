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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->default(0);
            $table->unsignedBigInteger('blog_category_id');
            $table->text('slug');
            $table->string('image')->nullable();
            $table->bigInteger('views')->default(0);
            $table->boolean('show_homepage')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->text('tags')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

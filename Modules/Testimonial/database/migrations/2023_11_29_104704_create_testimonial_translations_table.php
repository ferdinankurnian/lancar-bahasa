<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Testimonial\app\Models\Testimonial;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonial_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Testimonial::class);
            $table->string('lang_code')->index();
            $table->string('name');
            $table->string('designation');
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_translations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Frontend\app\Models\Section;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Section::class)->constrained()->cascadeOnDelete();
            $table->string('lang_code');
            $table->json('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('section_translations');
    }
};

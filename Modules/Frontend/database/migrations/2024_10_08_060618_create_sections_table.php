<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Frontend\app\Models\Home;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Home::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->json('global_content')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('sections');
    }
};

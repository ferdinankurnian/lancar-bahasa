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
        Schema::create('instructor_request_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('need_certificate')->default(1);
            $table->boolean('need_identity_scan')->default(1);
            $table->text('bank_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_request_settings');
    }
};

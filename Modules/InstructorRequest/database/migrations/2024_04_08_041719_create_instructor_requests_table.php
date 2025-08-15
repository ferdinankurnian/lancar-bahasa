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
        Schema::create('instructor_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('certificate')->nullable();
            $table->text('identity_scan')->nullable();
            $table->string('payout_account')->nullable();
            $table->text('payout_information')->nullable();
            $table->text('extra_information')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_requests');
    }
};

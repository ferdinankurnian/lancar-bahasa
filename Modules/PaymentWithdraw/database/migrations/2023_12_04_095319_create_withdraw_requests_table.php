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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('method');
            $table->decimal('current_amount', 8, 2)->default(0.00);
            $table->decimal('withdraw_amount', 8, 2)->default(0.00);
            $table->text('account_info');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('approved_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};

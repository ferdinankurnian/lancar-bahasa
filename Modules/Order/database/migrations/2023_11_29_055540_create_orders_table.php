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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('invoice_id')->nullable();
            $table->foreignId('buyer_id')->nullable();
            $table->foreignId('seller_id')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'declined'])->default('pending');
            $table->boolean('has_coupon')->default(0);
            $table->string('coupon_code')->nullable();
            $table->integer('coupon_discount_percent')->nullable();
            $table->double('coupon_discount_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->double('payable_amount')->nullable();
            $table->double('gateway_charge')->nullable();
            $table->double('payable_with_charge')->nullable();
            $table->double('paid_amount')->nullable();
            $table->double('conversion_rate')->nullable();
            $table->string('payable_currency')->nullable();
            $table->text('payment_details')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('commission_rate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

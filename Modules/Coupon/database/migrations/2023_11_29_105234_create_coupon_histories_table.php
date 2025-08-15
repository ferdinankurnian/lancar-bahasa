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
        Schema::create('coupon_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('coupon_code');
            $table->integer('coupon_id');
            $table->decimal('discount_amount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_histories');
    }
};

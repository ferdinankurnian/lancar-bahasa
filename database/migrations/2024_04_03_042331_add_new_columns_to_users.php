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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['instructor', 'student'])->default('student')->after('email');
            $table->text('bio')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('job_title')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->string('github')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

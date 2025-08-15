<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PageBuilder\app\Models\CustomPage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomPage::class);
            $table->string('lang_code');
            $table->string('name')->nullable();
            $table->longText('content')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_page_translations');
    }
};

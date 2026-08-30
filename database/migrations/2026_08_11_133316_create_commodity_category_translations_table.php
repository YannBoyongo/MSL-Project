<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['commodity_category_id', 'language_id'], 'commodity_cat_lang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_category_translations');
    }
};

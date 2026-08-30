<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_unit_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measurement_unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['measurement_unit_id', 'language_id'], 'mu_trans_lang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_unit_translations');
    }
};

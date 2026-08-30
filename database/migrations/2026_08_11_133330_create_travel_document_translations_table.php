<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_document_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();

            $table->unique(['travel_document_id', 'language_id'], 'travel_doc_lang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_document_translations');
    }
};

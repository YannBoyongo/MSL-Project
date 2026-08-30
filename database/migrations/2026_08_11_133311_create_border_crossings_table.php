<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('border_crossings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_a_id')->constrained('countries')->cascadeOnDelete();
            $table->foreignId('country_b_id')->constrained('countries')->cascadeOnDelete();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('status')->default('open');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('border_crossings');
    }
};

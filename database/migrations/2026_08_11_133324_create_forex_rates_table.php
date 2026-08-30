<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forex_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forex_bureau_id')->constrained()->cascadeOnDelete();
            $table->foreignId('base_currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('quote_currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->decimal('buy_rate', 15, 6);
            $table->decimal('sell_rate', 15, 6);
            $table->date('rate_date');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['forex_bureau_id', 'rate_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_rates');
    }
};

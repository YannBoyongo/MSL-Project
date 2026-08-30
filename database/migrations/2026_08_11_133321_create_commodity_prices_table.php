<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('market_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 15, 4);
            $table->date('price_date');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['commodity_id', 'market_id', 'currency_id', 'price_date'], 'commodity_price_unique');
            $table->index('price_date');
            $table->index('market_id');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_prices');
    }
};

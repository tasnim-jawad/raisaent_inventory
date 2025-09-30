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
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Change bigInteger columns to decimal for better float support
            $table->decimal('currency_exchange_rate', 10, 4)->nullable()->change();
            $table->decimal('subtotal', 15, 2)->nullable()->change();
            $table->decimal('other_cost', 15, 2)->nullable()->change();
            $table->decimal('discount', 15, 2)->nullable()->change();
            $table->decimal('total', 15, 2)->nullable()->change();
            $table->decimal('total_in_bdt', 15, 2)->nullable()->change();
            $table->decimal('due', 15, 2)->nullable()->change();
            $table->decimal('paid', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Revert back to bigInteger
            $table->bigInteger('currency_exchange_rate')->nullable()->change();
            $table->bigInteger('subtotal')->nullable()->change();
            $table->bigInteger('other_cost')->nullable()->change();
            $table->bigInteger('discount')->nullable()->change();
            $table->bigInteger('total')->nullable()->change();
            $table->bigInteger('total_in_bdt')->nullable()->change();
            $table->bigInteger('due')->nullable()->change();
            $table->bigInteger('paid')->nullable()->change();
        });
    }
};

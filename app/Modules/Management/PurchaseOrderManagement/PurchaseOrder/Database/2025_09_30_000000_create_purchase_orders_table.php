<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Database\create_purchase_orders_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('reference', 100)->nullable();
            $table->integer('suppliyer_id')->nullable();
            $table->date('date')->nullable();
            $table->string('currency_id')->nullable();
            $table->decimal('currency_exchange_rate', 10, 4)->nullable();
            $table->date('expected_time_of_delivery')->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->decimal('other_cost', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('total_in_bdt', 15, 2)->nullable();
            $table->decimal('due', 15, 2)->nullable();
            $table->decimal('paid', 15, 2)->nullable();
            $table->enum('order_status', ['due', 'paid'])->nullable();

            $table->bigInteger('creator')->unsigned()->nullable();
            $table->string('slug', 150)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

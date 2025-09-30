<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\SalesOrderManagement\SalesOrder\Database\create_sales_orders_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('reference', 50)->nullable();
            $table->integer('customer_id')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('subtotal')->nullable()->unsigned();
            $table->bigInteger('due')->nullable()->unsigned();
            $table->bigInteger('paid')->nullable()->unsigned();
            $table->bigInteger('discount')->nullable()->unsigned();
            $table->bigInteger('total')->nullable()->unsigned();
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
        Schema::dropIfExists('sales_orders');
    }
};

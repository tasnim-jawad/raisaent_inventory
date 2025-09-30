<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\SalesOrderManagement\SalesOrder\Database\create_sales_order_has_sales_order_products_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_order_has_sales_order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_order_id')->nullable();
            $table->bigInteger('sales_order_product_id')->nullable();

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
        Schema::dropIfExists('sales_order_has_sales_order_products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WareHouseProductStock\Database\create_ware_house_product_stock_products_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ware_house_product_stock_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ware_house_product_stock_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('product_name', 100)->nullable();
            $table->bigInteger('quantity')->nullable()->unsigned();
            $table->bigInteger('available_for_stock')->nullable()->unsigned();

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
        Schema::dropIfExists('ware_house_product_stock_products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WareHouseProductStock\Database\create_ware_house_product_stocks_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ware_house_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('purchase_order_id')->nullable();
            $table->datetime('date')->nullable();

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
        Schema::dropIfExists('ware_house_product_stocks');
    }
};
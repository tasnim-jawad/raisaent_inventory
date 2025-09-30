<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Database\create_warehouse_swap_products_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_swap_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_warehouse_id')->nullable();
            $table->bigInteger('to_warehouse_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('quantity')->nullable();

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
        Schema::dropIfExists('warehouse_swap_products');
    }
};
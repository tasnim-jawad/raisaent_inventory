<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WarehouseProductOut\Database\create_warehouse_product_outs_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_product_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id')->nullable();
            $table->string('sales_order_id', 20)->nullable();
            $table->date('date')->nullable();

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
        Schema::dropIfExists('warehouse_product_outs');
    }
};

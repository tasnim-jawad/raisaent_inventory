<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WarehouseProductOut\Database\create_warehouse_product_out_logs_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_product_out_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ware_house_product_out_id');
            $table->json('data')->nullable();
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
        Schema::dropIfExists('warehouse_product_out_logs');
    }
};

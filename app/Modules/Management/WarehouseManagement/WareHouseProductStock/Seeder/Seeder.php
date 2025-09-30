<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\WarehouseManagement\WareHouseProductStock\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'warehouse_id' => null,
                'purchase_order_id' => null,
                'date' => $faker->dateTime,
            ]);
        }
    }
}

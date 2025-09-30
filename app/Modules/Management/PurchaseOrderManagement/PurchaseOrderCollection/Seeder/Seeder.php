<?php
namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="/app/Modules/Management/PurchaseOrderManagement/PurchaseOrderCollection/Seeder/Seeder"
     */
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'purchase_order_id' => null,
                'amount' => null,
                'reference' => $faker->sentence,
            ]);
        }
    }
}
<?php
namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'title' => $faker->text(100),
                'reference' => $faker->sentence,
                'suppliyer_id' => $faker->randomNumber,
                'date' => $faker->dateTime,
                'currency_id' => $faker->randomNumber,
                'currency_exchange_rate' => null,
                'expected_time_of_delivery' => $faker->date,
                'subtotal' => null,
                'discount' => null,
                'total' => null,
                'total_in_bd' => null,
            ]);
        }
    }
}
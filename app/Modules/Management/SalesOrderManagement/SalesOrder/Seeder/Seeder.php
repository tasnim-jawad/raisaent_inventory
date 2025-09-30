<?php
namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\SalesOrderManagement\SalesOrder\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'order_title' => $faker->text(100),
                'reference' => $faker->text(50),
                'customer_id' => $faker->randomNumber,
                'date' => $faker->dateTime,
                'subtotal' => null,
                'due' => null,
                'paid' => null,
                'discount' => null,
                'total' => null,
                'order_status' => $faker->randomElement(array (
  0 => 'pending',
  1 => 'due',
  2 => 'paid',
)),
            ]);
        }
    }
}
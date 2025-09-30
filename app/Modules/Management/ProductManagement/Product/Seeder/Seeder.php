<?php

namespace App\Modules\Management\ProductManagement\Product\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\ProductManagement\Product\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\ProductManagement\Product\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'suppliyer_id' => $faker->randomNumber(1,10),
                'product_category_id' => $faker->randomNumber(1,50),
                'product_sub_category_id' => $faker->randomNumber(1,50),
            ]);
        }
    }
}

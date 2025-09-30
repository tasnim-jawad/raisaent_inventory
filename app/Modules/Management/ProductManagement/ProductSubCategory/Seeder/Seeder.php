<?php

namespace App\Modules\Management\ProductManagement\ProductSubCategory\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\ProductManagement\ProductSubCategory\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\ProductManagement\ProductSubCategory\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'product_category_id' => $faker->randomNumber(1,50),
                'title' => $faker->text(100),
                'parent_id' =>$faker->randomNumber(1,50),
            ]);
        }
    }
}

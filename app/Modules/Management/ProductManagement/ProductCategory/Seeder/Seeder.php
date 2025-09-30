<?php

namespace App\Modules\Management\ProductManagement\ProductCategory\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\ProductManagement\ProductCategory\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\ProductManagement\ProductCategory\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 50; $i++) {
            self::$model::create([
                'title' => $faker->text(100),
                'parent_id' => null,
            ]);
        }
    }
}

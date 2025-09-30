<?php

namespace App\Modules\Management\AccountManagement\AccountSubCategory\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\AccountManagement\AccountSubCategory\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\AccountManagement\AccountSubCategory\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'account_category_id' => $faker->randomNumber,
                'title' => $faker->text(100),
                'type' => $faker->randomElement(array(
                    0 => 'income',
                    1 => 'expense',
                )),
            ]);
        }
    }
}

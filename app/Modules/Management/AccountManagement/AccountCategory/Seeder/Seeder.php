<?php

namespace App\Modules\Management\AccountManagement\AccountCategory\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\AccountManagement\AccountCategory\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\AccountManagement\AccountCategory\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'title' => $faker->text(100),
                'type' => $faker->randomElement(array(
                    0 => 'income',
                    1 => 'expense',
                )),
            ]);
        }
    }
}

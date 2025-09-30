<?php

namespace App\Modules\Management\SuppliyerManagement\Suppliyer\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\SuppliyerManagement\Suppliyer\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\SuppliyerManagement\Suppliyer\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([
                'suppliyer_group_id' => $faker->randomNumber(1, 10),
                'name' => $faker->text(100),
                'phone' => $faker->text(20),
                'email' => $faker->text(50),
                'address' => $faker->sentence,
                'comment' => $faker->paragraph,
                'country' => $faker->text(20),
            ]);
        }
    }
}

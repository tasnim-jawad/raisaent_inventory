<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

/**
 * User seeder management.
 */

use App\Modules\Management\UserManagement\Role\Seeder\Seeder as RoleSeeder;
use App\Modules\Management\UserManagement\User\Seeder\Seeder as UserSeeder;
use App\Modules\Management\SettingManagement\WebsiteSettings\Seeder\Seeder as WebsiteSettingsSeeder;

/**
 * Suppliyer seeder management.
 */

use App\Modules\Management\SuppliyerManagement\SuppliyerGroup\Seeder\Seeder as SuppliyerGroupSeeder;
use App\Modules\Management\SuppliyerManagement\Suppliyer\Seeder\Seeder as SuppliyerSeeder;

/**
 * Product seeder management.
 */

use App\Modules\Management\ProductManagement\ProductCategory\Seeder\Seeder as ProductCategorySeeder;
use App\Modules\Management\ProductManagement\ProductSubCategory\Seeder\Seeder as ProductSubCategorySeeder;
use App\Modules\Management\ProductManagement\Product\Seeder\Seeder as ProductSeeder;

/**
 * Customer seeder management.
 */

use App\Modules\Management\CustomerManagement\CustomerGroup\Seeder\Seeder as CustomerGroupSeeder;
use App\Modules\Management\CustomerManagement\Customer\Seeder\Seeder as CustomerSeeder;

/**
 * Account seeder management.
 */

use App\Modules\Management\AccountManagement\AccountCategory\Seeder\Seeder as AccountCategorySeeder;
use App\Modules\Management\AccountManagement\AccountSubCategory\Seeder\Seeder as AccountSubCategorySeeder;
use App\Modules\Management\AccountManagement\AccountIncome\Seeder\Seeder as AccountIncomeSeeder;
use App\Modules\Management\AccountManagement\AccountExpense\Seeder\Seeder as AccountExpenseSeeder;

/**
 * Warehouse seeder management.
 */

use App\Modules\Management\WarehouseManagement\WareHouse\Seeder\Seeder as WareHouseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            /**
             * User seeder management.
             */
            RoleSeeder::class,
            UserSeeder::class,
            WebsiteSettingsSeeder::class,
            /**
             * Suppliyer seeder management.
             */
            SuppliyerGroupSeeder::class,
            SuppliyerSeeder::class,
            /**
             * Product seeder management.
             */
            ProductCategorySeeder::class,
            ProductSubCategorySeeder::class,
            ProductSeeder::class,
            /**
             * Customer seeder management.
             */
            CustomerGroupSeeder::class,
            CustomerSeeder::class,

            /**
             * Accounts seeder management.
             */
            AccountCategorySeeder::class,
            AccountSubCategorySeeder::class,
            AccountIncomeSeeder::class,
            AccountExpenseSeeder::class,
            /**
             * Warehouse seeder management.
             */
            WareHouseSeeder::class

        ]);
    }
}

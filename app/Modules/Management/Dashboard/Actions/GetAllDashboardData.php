<?php

namespace App\Modules\Management\Dashboard\Actions;

class GetAllDashboardData
{

    public static $PurchaseOrders = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;
    public static $SalesOrders = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;

    public static function execute()
    {
        try {

        

            $data = [];

            $getTotalProducts = self::GetTotalProducts();
            $getTotalSuppliers = self::GetTotalSuppliers();
            $getTotalCustomers = self::GetTotalCustomers();
            $getTotalPurchaseOrders = self::GetTotalPurchaseOrders();
            $getTotalWarehouses = self::GetTotalWarehouses();
            $getTotalCategories = self::GetTotalCategories();
            $getTotalExpenses = self::GetTotalExpenses();
            $getTotalIncomes = self::GetTotalIncomes();
            $getTotalSalesOrders = self::GetTotalSalesOrders();
            $getTotalProductStocks = self::GetTotalProductStocks();
            $getLatesPurchaseOrders = self::$PurchaseOrders::with('suppliyer')->latest()->take(10)->get();
            $getLatesSalesOrders = self::$SalesOrders::with('customer')->latest()->take(10)->get();


            $data['getLatesOrders'] = $getLatesPurchaseOrders;
            $data['getLatesSalesOrders'] = $getLatesSalesOrders;
            $data['getTotalProducts'] = $getTotalProducts;
            $data['getTotalSuppliers'] = $getTotalSuppliers;
            $data['getTotalCustomers'] = $getTotalCustomers;
            $data['getTotalPurchaseOrders'] = $getTotalPurchaseOrders;
            $data['getTotalWarehouses'] = $getTotalWarehouses;
            $data['getTotalCategories'] = $getTotalCategories;
            $data['getTotalExpenses'] = $getTotalExpenses;
            $data['getTotalIncomes'] = $getTotalIncomes;
            $data['getTotalSalesOrders'] = $getTotalSalesOrders;
            $data['getTotalProductStocks'] = $getTotalProductStocks;

            return entityResponse($data);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }

    public static function GetTotalProducts()
    {
        $ProductModel = \App\Modules\Management\ProductManagement\Product\Models\Model::class;
        $totalProducts = $ProductModel::query()->count();
        return $totalProducts;
    }

    public static function GetTotalSuppliers()
    {
        $SuppliyerModel = \App\Modules\Management\SuppliyerManagement\Suppliyer\Models\Model::class;
        $totalSuppliers = $SuppliyerModel::query()->count();
        return $totalSuppliers;
    }

    public static function GetTotalCustomers()
    {
        $CustomerModel = \App\Modules\Management\CustomerManagement\Customer\Models\Model::class;
        $totalCustomers = $CustomerModel::query()->count();
        return $totalCustomers;
    }

    public static function GetTotalPurchaseOrders()
    {
        $PurchaseOrderModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;
        $totalOrders =  $PurchaseOrderModel::query()->count();
        return $totalOrders;
    }

    public static function GetTotalWarehouses()
    {
        $WareHouseModel = \App\Modules\Management\WarehouseManagement\WareHouse\Models\Model::class;
        $totalWarehouses = $WareHouseModel::query()->count();
        return $totalWarehouses;
    }

    public static function GetTotalCategories()
    {
        $CategoryModel = \App\Modules\Management\ProductManagement\ProductCategory\Models\Model::class;
        $totalCategories = $CategoryModel::query()->count();
        return $totalCategories;
    }

    public static function GetTotalIncomes()
    {
        $IncomeModel = \App\Modules\Management\AccountManagement\AccountIncome\Models\Model::class;
        $totalAccounts =  $IncomeModel::query()->sum('amount');
        return $totalAccounts;
    }

    public static function GetTotalExpenses()
    {
        $ExpenseModel = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;
        $totalExpenses = $ExpenseModel::query()->sum('amount');
        return $totalExpenses;
    }



    public static function GetTotalSalesOrders()
    {
        $SalesOrderModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;
        $totalSalesOrders = $SalesOrderModel::query()->count();
        return $totalSalesOrders;
    }



    public static function GetTotalProductStocks()
    {
        $WareHouseStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
        $totalProductStocks =  $WareHouseStockModel::query()->count();
        return $totalProductStocks;
    }
}

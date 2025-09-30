//app layout
import Layout from "../Layouts/Layout.vue";
//Dashboard
import Dashboard from "../Management/Dashboard/Dashboard.vue";
//SettingsRoutes
import SettingsRoutes from "../Management/Settings/setup/routes.js";
//routes
import PurchaseOrderCollectionRoutes from '../Management/PurchaseOrderManagement/PurchaseOrderCollection/setup/routes.js';
import ReportingRoutes from '../Management/Reporting/setup/routes.js';
import WarehouseSwapProductRoutes from '../Management/WarehouseManagement/WarehouseSwapProduct/setup/routes.js'; 
import CustomerRoutes from '../Management/CustomerManagement/Customer/setup/routes.js';
import CustomerGroupRoutes from '../Management/CustomerManagement/CustomerGroup/setup/routes.js';
import AccountExpenseRoutes from '../Management/AccountManagement/AccountExpense/setup/routes.js';
import AccountIncomeRoutes from '../Management/AccountManagement/AccountIncome/setup/routes.js';
import AccountSubCategoryRoutes from '../Management/AccountManagement/AccountSubCategory/setup/routes.js';
import AccountCategoryRoutes from '../Management/AccountManagement/AccountCategory/setup/routes.js';
import SalesOrderCollectionHistoryRoutes from '../Management/SalesOrderManagement/SalesOrderCollectionHistory/setup/routes.js';
import SalesOrderRoutes from '../Management/SalesOrderManagement/SalesOrder/setup/routes.js';
import WarehouseProductOutRoutes from '../Management/WarehouseManagement/WarehouseProductOut/setup/routes.js';
import WareHouseProductStockRoutes from '../Management/WarehouseManagement/WareHouseProductStock/setup/routes.js';
import WareHouseRoutes from '../Management/WarehouseManagement/WareHouse/setup/routes.js';
import PurchaseOrderRoutes from '../Management/PurchaseOrderManagement/PurchaseOrder/setup/routes.js';
import SuppliyerRoutes from '../Management/SuppliyerManagement/Suppliyer/setup/routes.js';
import ProductRoutes from '../Management/ProductManagement/Product/setup/routes.js';
import ProductSubCategoryRoutes from '../Management/ProductManagement/ProductSubCategory/setup/routes.js';
import ProductCategoryRoutes from '../Management/ProductManagement/ProductCategory/setup/routes.js';


import UserRoutes from '../Management/UserManagement/User/setup/routes.js';



const routes = {
    path: '',
    component: Layout,
    children: [
        {
            path: 'dashboard',
            component: Dashboard,
            name: 'adminDashboard',
        },
        //management routes
        PurchaseOrderCollectionRoutes,
        ReportingRoutes,
        WarehouseSwapProductRoutes,
        CustomerRoutes,
        CustomerGroupRoutes,
        AccountExpenseRoutes,
        AccountIncomeRoutes,
        AccountSubCategoryRoutes,
        AccountCategoryRoutes,
        SalesOrderCollectionHistoryRoutes,
        SalesOrderRoutes,
        WarehouseProductOutRoutes,
        WareHouseProductStockRoutes,
        WareHouseRoutes,
        PurchaseOrderRoutes,
        SuppliyerRoutes,
        ProductRoutes,
        ProductSubCategoryRoutes,
        ProductCategoryRoutes,
        UserRoutes,
        //settings
        SettingsRoutes,
    ],
};

export default routes;


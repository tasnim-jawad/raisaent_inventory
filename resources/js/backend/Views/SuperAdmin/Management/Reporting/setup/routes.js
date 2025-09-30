import setup from ".";
import AllIncomeReport from "../pages/AllIncomeReport.vue";
import AllExpenseReport from "../pages/AllExpenseReport.vue";
import AllIncomeExpenseReport from "../pages/AllIncomeExpenseReport.vue";
import Layout from "../pages/Layout.vue";

let route_prefix = setup.route_prefix;
let route_path = setup.route_path;

const routes = {
    path: route_path,
    component: Layout,
    children: [
        {
            path: "all-income-report",
            name: "AllIncomeReport",
            component: AllIncomeReport,
        },
        {
            path: "all-expense-report",
            name: "AllExpenseReport",
            component: AllExpenseReport,
        },
        {
            path: "all-income-expense-report",
            name: "AllIncomeExpenseReport",
            component: AllIncomeExpenseReport,
        },
      
    ],
};

export default routes;


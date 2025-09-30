
import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "SalesOrder";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "sales-orders",

    module_name: "sales-order",
    store_prefix: "sales_order",
    route_prefix: "SalesOrder",
    route_path: "sales-order",

    select_fields: [
        "id",
        "order_title",
            "reference",
            "customer_id",
            "date",
            "subtotal",
            "due",
            "paid",
            "discount",
            "total",
            "order_status",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "order_title",
            "reference",
            "customer_id",
            "date",
            "subtotal",
            "due",
            "paid",
            "discount",
            "total",
            "order_status",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "order_title",
            "reference",
            "customer_id",
            "date",
            "subtotal",
            "due",
            "paid",
            "discount",
            "total",
            "order_status",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "order_title",
            "reference",
            "customer_id",
            "date",
            "subtotal",
            "due",
            "paid",
            "discount",
            "total",
            "order_status",
        "status",
        "created_at",
    ],

    layout_title: prefix + " Management",
    page_title: `${prefix} Management`,

    all_page_title: "All " + prefix,
    details_page_title: "Details " + prefix,
    create_page_title: "Create " + prefix,
    edit_page_title: "Edit " + prefix,
};

export default setup;

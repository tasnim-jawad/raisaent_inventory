
import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "PurchaseOrder";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "purchase-orders",

    module_name: "purchase-order",
    store_prefix: "purchase_order",
    route_prefix: "PurchaseOrder",
    route_path: "purchase-order",

    select_fields: [
        "id",
        "title",
            "reference",
            "suppliyer_id",
            "date",
            "currency_id",
            "currency_exchange_rate",
            "expected_time_of_delivery",
            "subtotal",
            "discount",
            "total",
            "total_in_bd",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "title",
            "reference",
            "suppliyer_id",
            "date",
            "currency_id",
            "currency_exchange_rate",
            "expected_time_of_delivery",
            "subtotal",
            "discount",
            "total",
            "total_in_bd",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "title",
            "reference",
            "suppliyer_id",
            "date",
            "currency_id",
            "currency_exchange_rate",
            "expected_time_of_delivery",
            "subtotal",
            "discount",
            "total",
            "total_in_bd",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "title",
            "reference",
            "suppliyer_id",
            "date",
            "currency_id",
            "currency_exchange_rate",
            "expected_time_of_delivery",
            "subtotal",
            "discount",
            "total",
            "total_in_bd",
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

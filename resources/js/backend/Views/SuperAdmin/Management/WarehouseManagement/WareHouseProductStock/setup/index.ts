import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "WareHouseProductStock";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "ware-house-product-stocks",

    module_name: "ware-house-product-stock",
    store_prefix: "ware_house_product_stock",
    route_prefix: "WareHouseProductStock",
    route_path: "ware-house-product-stock",

    select_fields: [
        "id",
        "warehouse_id",
        "purchase_order_id",
        "date",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "warehouse_id",
        "purchase_order_id",
        "date",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "warehouse",
        "purchase order",
        "Total Stock",
        "date",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "warehouse",
        "purcahase_order",
        "ware_house_product_stock_products_count",
        "date",
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

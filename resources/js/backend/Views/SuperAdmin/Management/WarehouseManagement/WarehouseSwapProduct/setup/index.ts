import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "WarehouseSwapProduct";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "warehouse-swap-products",

    module_name: "warehouse-swap-product",
    store_prefix: "warehouse_swap_product",
    route_prefix: "WarehouseSwapProduct",
    route_path: "warehouse-swap-product",

    select_fields: [
        "id",
        "from_warehouse_id",
        "to_warehouse_id",
        "product_id",
        "quantity",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "from_warehouse_id",
        "to_warehouse_id",
        "quantity",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "from warehouse",
        "to warehouse",
        "product",
        "quantity",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "from_warehouse",
        "to_warehouse",
        "product",
        "quantity",
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

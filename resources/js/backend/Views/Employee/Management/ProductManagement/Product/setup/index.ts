import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "Product";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "products",

    module_name: "product",
    store_prefix: "product",
    route_prefix: "Product",
    route_path: "product",

    select_fields: [
        "id",
        "title",
        "description",
        "suppliyer_id",
        "product_category_id",
        "product_sub_category_id",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "title",
        "description",
        "suppliyer_id",
        "product_category_id",
        "product_sub_category_id",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "title",
        "description",
        "suppliyer_id",
        "product_category_id",
        "product_sub_category_id",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "title",
        "description",
        "suppliyer_id",
        "product_category_id",
        "product_sub_category_id",
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

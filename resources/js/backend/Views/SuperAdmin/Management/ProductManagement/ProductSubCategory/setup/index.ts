import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "ProductSubCategory";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "product-sub-categories",

    module_name: "product-sub-category",
    store_prefix: "product_sub_category",
    route_prefix: "ProductSubCategory",
    route_path: "product-sub-category",

    select_fields: [
        "id",
        "product_category_id",
        "title",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "product_category_id",
        "title",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "product category",
        "title",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "category",
        "title",
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

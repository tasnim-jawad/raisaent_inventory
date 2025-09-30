
import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "WareHouse";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "ware-houses",

    module_name: "ware-house",
    store_prefix: "ware_house",
    route_prefix: "WareHouse",
    route_path: "ware-house",

    select_fields: [
        "id",
        "name",
            "address",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "name",
            "address",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "name",
            "address",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "name",
            "address",
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

import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "PurchaseOrderProviding";

const setup: setup_type = {
  prefix,
  permission: ["admin", "super_admin"],

  api_host: app_config.api_host,
  api_version: app_config.api_version,
  api_end_point: "purchase-order-collections",

  module_name: "purchase-order-collection",
  store_prefix: "purchase_order_collection",
  route_prefix: "PurchaseOrderCollection",
  route_path: "purchase-order-collection",

  select_fields: [
    "id",
    "purchase_order_id",
    "amount",
    "reference",
    "status",
    "slug",
    "created_at",
    "deleted_at",
  ],

  sort_by_cols: [
    "id",
    "purchase_order_id",
    "amount",
    "reference",
    "status",
    "created_at",
  ],
  table_header_data: [
    "id",
    "purchase_order",
    "amount",
    "reference",
    "status",
    "created_at",
  ],
  table_row_data: [
    "id",
    "purchase_order",
    "amount",
    "reference",
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

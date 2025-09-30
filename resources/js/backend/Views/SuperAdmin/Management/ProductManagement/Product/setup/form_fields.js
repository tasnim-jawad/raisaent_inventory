export default [
  {
    name: "title",
    label: "Enter your title",
    type: "text",
    value: "",
  },

  {
    name: "suppliyer_id",
    label: "Select suppliyer",
    type: "select",
    value: "",
  },

  {
    name: "product_category_id",
    label: "Select product category id",
    type: "select",
    value: "",
    onchangeAction: "get_product_sub_category_by_category_id",
  },

  {
    name: "product_sub_category_id",
    label: "Enter your product sub category id",
    type: "select",
    value: "",
  },
  {
    name: "image",
    label: "Upload image",
    type: "file",
    value: "",
  },
  {
    name: "description",
    label: "Enter your description",
    type: "textarea",
    value: "",
    row_col_class: "col-md-12",
  },
];

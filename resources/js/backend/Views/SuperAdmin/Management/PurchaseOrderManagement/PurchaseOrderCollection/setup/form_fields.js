// export default [
// 	{
// 		name: "purchase_order_id",
// 		label: "Enter your purchase order id",
// 		type: "number",
// 		value: "",
// 	},

// 	{
// 		name: "amount",
// 		label: "Enter your amount",
// 		type: "number",
// 		value: "",
// 	},

// 	{
// 		name: "reference",
// 		label: "Enter your reference",
// 		type: "text",
// 		value: "",
// 	},
// ];

export default [
  {
    name: "purchase_order_id",
    label: "Select purchase order",
    type: "select",
    value: "",
    data_list: [],
    onchangeAction:
      "get_purchase_order_collection_history_by_purchase_order_id",
  },

  {
    name: "amount",
    label: "Enter your amount",
    type: "number",
    value: "",
  },
  {
    name: "reference",
    label: "Enter your reference",
    type: "text",
    value: "",
    row_col_class: "col-md-6",
  },
];

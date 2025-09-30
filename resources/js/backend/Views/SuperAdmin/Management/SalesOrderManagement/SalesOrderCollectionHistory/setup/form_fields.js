export default [
	{
		name: "sales_order_id",
		label: "Select sales order",
		type: "select",
		value: "",
        data_list: [],
        onchangeAction: "get_sales_order_collection_history_by_sales_order_id",
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
    }
];

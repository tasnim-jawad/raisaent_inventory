export default [
	{
		name: "from_warehouse_id",
		label: "Select from warehouse ",
		type: "select",
		value: "",
        data_list: [],
		onchangeAction:'get_product_available_quantity',

	},

	{
		name: "to_warehouse_id",
		label: "Select to warehouse ",
		type: "select",
		value: "",
        data_list: [],
	},
	{
		name: "product_id",
		label: "Select product  ",
		type: "select",
		value: "",
        data_list: [],
		onchangeAction:'get_product_available_quantity',
	},

	{
		name: "quantity",
		label: "Enter your quantity",
		type: "number",
		value: "",
	},
];

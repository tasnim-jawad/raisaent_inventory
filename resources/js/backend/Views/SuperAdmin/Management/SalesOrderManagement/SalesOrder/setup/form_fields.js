export default [
	{
		name: "order_title",
		label: "Enter your order title",
		type: "text",
		value: "",
	},

	{
		name: "reference",
		label: "Enter your reference",
		type: "text",
		value: "",
	},

	{
		name: "customer_id",
		label: "Enter your customer id",
		type: "number",
		value: "",
	},

	{
		name: "date",
		label: "Enter your date",
		type: "datetime",
		value: "",
	},

	{
		name: "subtotal",
		label: "Enter your subtotal",
		type: "number",
		value: "",
	},

	{
		name: "due",
		label: "Enter your due",
		type: "number",
		value: "",
	},

	{
		name: "paid",
		label: "Enter your paid",
		type: "number",
		value: "",
	},

	{
		name: "discount",
		label: "Enter your discount",
		type: "number",
		value: "",
	},

	{
		name: "total",
		label: "Enter your total",
		type: "number",
		value: "",
	},

	{
		name: "order_status",
		label: "Enter your order status",
		type: "select",
		label: "Select order status",
		multiple: false,
		data_list: [
			{
				label: "Pending",
				value: "pending",
			},
			{
				label: "Due",
				value: "due",
			},
			{
				label: "Paid",
				value: "paid",
			},
		],
		value: "",
	},
];

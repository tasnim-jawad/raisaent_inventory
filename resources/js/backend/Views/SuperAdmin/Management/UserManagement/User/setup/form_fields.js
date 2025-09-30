export default [
  {
    name: "name",
    label: "Enter  name",
    type: "text",
    value: "",
  },

  {
    name: "email",
    label: "Enter  email",
    type: "text",
    value: "",
  },
  {
    name: "phone_number",
    label: "Enter  phone number",
    type: "text",
    value: "",
  },

  {
    name: "password_in_text",
    label: "Enter  password",
    type: "text",
    value: "",
  },
  {
    name: "present_address",
    label: "Enter present  address",
    type: "text",
    value: "",
  },
  {
    name: "permanent_address",
    label: "Enter permanent address",
    type: "text",
    value: "",
  },
  {
    name: "designation",
    label: "Enter designation",
    type: "text",
    value: "",
  },
  {
    name: "nid",
    label: "Enter nid",
    type: "text",
    value: "",
  },
  {
    name: "role_id",
    label: "Select  role ",
    type: "select",
    value: "",
    data_list: [],
    onchange: "changeAction",
  },
  {
    name: "join_date",
    label: "Enter join date",
    type: "date",
    value: "",
    is_visible: false,
  },

  {
    name: "salery",
    label: "Enter  salery",
    type: "number",
    value: "",
    is_visible: false,
  },

  {
    name: "can_login",
    label: "Can login",
    type: "select",
    value: "0",
    is_visible: false,
    data_list: [
      {
        label: "Yes",
        value: "1",
      },
      {
        label: "No",
        value: "0",
      },
    ],
  },

  {
    name: "image",
    label: "Enter  image",
    type: "file",
    multiple: false,
    value: "",
  },

  {
    name: "comment",
    label: "Enter  comment",
    type: "textarea",
    value: "",
    row_col_class: "col-md-12",
  },
];

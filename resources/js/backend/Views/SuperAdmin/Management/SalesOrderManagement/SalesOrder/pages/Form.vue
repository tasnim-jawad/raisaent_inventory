<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">Create Sales Order</h5>
          <div>
            <!--v-if--><a
              href="#/purchase-order/all"
              class="btn btn-outline-warning btn-sm"
              >All Sales Order</a
            >
          </div>
        </div>
        <div class="card-body card_body_fixed_height">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Enter your title</label>
                <div class="mt-1 mb-3">
                  <input
                    class="form-control form-control-square mb-2"
                    type="text"
                    name="title"
                    id="title"
                    v-model="formData.title"
                  />
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Enter your reference</label>
                <div class="mt-1 mb-3">
                  <input
                    class="form-control form-control-square mb-2"
                    type="text"
                    name="reference"
                    id="reference"
                    v-model="formData.reference"
                  />
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select Customer</label>
                <div class="mt-1 mb-3">
                  <select
                    class="form-control form-control-square mb-2"
                    name="customer_id"
                    id="customer_id"
                    v-model="formData.customer_id"
                  >
                    <option value="">Select customer</option>
                    <option
                      v-for="item in customers"
                      :key="item"
                      :value="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select date</label>
                <div class="mt-1 mb-3">
                  <input
                    class="form-control form-control-square mb-2"
                    type="date"
                    name="date"
                    id="date"
                    v-model="formData.date"
                  />
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
          </div>
          <div class="row justify-content-center my-3">
            <div class="col-md-7">
              <div class="form-group">
                <label for="">Select Products</label>
                <select
                  name=""
                  id=""
                  class="form-control"
                  @change="set_product_item($event.target.value)"
                >
                  <option value="">Select Product</option>
                  <option
                    v-for="item in products"
                    :value="item.id"
                    :key="item.id"
                  >
                    {{ item.title }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div>
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Available Quantity</th>
                  <th>Price</th>
                  <th>SubTotal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item, index) in formData.product_items"
                  :key="index"
                >
                  <td>
                    <input
                      class="form-control form-control-square"
                      type="hidden"
                      v-model="item.product_id"
                    />
                    <input
                      class="form-control form-control-square"
                      type="text"
                      readonly
                      v-model="item.product_name"
                    />
                  </td>
                  <td>
                    <input
                      class="form-control form-control-square"
                      type="number"
                      v-model="item.quantity"
                    />
                  </td>
                  <td>
                    <input
                      readonly
                      class="form-control form-control-square"
                      type="number"
                      v-model="item.available_quantity"
                    />
                  </td>
                  <td>
                    <input
                      class="form-control form-control-square"
                      type="number"
                      v-model="item.price"
                    />
                  </td>

                  <td>
                    <input
                      class="form-control form-control-square"
                      type="text"
                      v-model="item.subtotal"
                    />
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-danger btn-outline-behance"
                      @click="removeItem(index)"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="row justify-content-end my-3">
              <div class="col-md-4">
                <table class="table table-bordered table-hover table-striped">
                  <tr>
                    <td colspan="2">Total</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        readonly
                        v-model="formData.subtotal"
                      />
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2">Discount</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        v-model="formData.discount"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Grand Total</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        readonly
                        v-model="formData.total"
                      />
                    </td>
                  </tr>
                  <tr v-if="!param_id">
                    <td colspan="2">Paid</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        v-model="formData.paid"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Due</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        readonly
                        v-model="formData.due"
                      />
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-light btn-square px-5 w-25">
            <i class="icon-lock"></i> Submit
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { store } from "../store";
import setup from "../setup";
import form_fields from "../setup/form_fields";

export default {
  data: () => ({
    setup,
    param_id: null,
    products: [],
    customers: [],

    formData: {
      title: "",
      reference: "",
      customer_id: "",
      date: "",
      subtotal: 0,
      discount: 0,
      total: 0,
      paid: 0,
      due: 0,
      product_items: [],
    },
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    if (id) {
      this.set_fields(id);
    }

    await this.get_all_products();
    await this.get_all_customers();
  },
  methods: {
    ...mapActions(store, {
      create: "create",
      update: "update",
      details: "details",
      get_all: "get_all",
      set_only_latest_data: "set_only_latest_data",
    }),
    reset_fields: function () {},
    set_fields: async function (id) {
      this.param_id = id;
      await this.details(id);
      if (this.item) {
        this.formData.title = this.item.title;
        this.formData.reference = this.item.reference;
        this.formData.customer_id = this.item.customer_id;
        this.formData.date = this.item.date;
        this.formData.subtotal = this.item.subtotal;
        this.formData.discount = this.item.discount;
        this.formData.total = this.item.total;
        this.formData.paid = this.item.paid;
        this.formData.due = this.item.due;
        this.formData.product_items = this.item.sales_order_products;
      }
    },

    submitHandler: async function ($event) {
      this.set_only_latest_data(true);
      if (this.param_id) {
        let response = await this.update(this.formData);
        // await this.get_all();
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data successfully updated");
          this.$router.push({
            name: `All${this.setup.route_prefix}`,
          });
        }
      } else {
        let response = await this.create(this.formData);
        // await this.get_all();
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data Successfully Created");
          this.$router.push({
            name: `All${this.setup.route_prefix}`,
          });
        }
      }
    },

    get_all_products: async function () {
      let response = await axios.get("products?get_all=1");
      if (response.data.status === "success") {
        this.products = response.data?.data;
      }
    },

    set_product_item: async function (id) {
      if (!Array.isArray(this.formData.product_items)) {
        this.formData.product_items = [];
      }

      let product = this.products.find((item) => item.id == id);

      if (!product) {
        alert("Product not found");
        return;
      }

      if (this.formData.product_items.some((item) => item.product_id == id)) {
        alert("Product already added");
        return;
      }

      let available_quantity = 0;

      let response = await axios.get(
        `get-product-stock-quantity-by-product-id/${id}`
      );

      if (response.data.status == "success") {
        available_quantity = response.data?.data;
      }

      this.formData.product_items.push({
        product_id: product.id,
        product_name: product.title,
        quantity: 0,
        available_quantity: available_quantity,
        price: 0,
        subtotal: 0,
      });
    },
    removeItem: function (index) {
      this.formData.product_items = this.formData.product_items.filter(
        (item, index2) => index != index2
      );
      if (this.formData.product_items.length === 0) {
        this.formData = {
          subtotal: 0,
          discount: 0,
          total: 0,
          paid: 0,
          due: 0,
        };
      }
    },
    get_all_customers: async function () {
      let response = await axios.get("customers?get_all=1");
      if (response.data.status == "success") {
        this.customers = response.data?.data || [];
      }
    },
  },

  watch: {
    "formData.product_items": {
      handler(newItems) {
        if (!Array.isArray(newItems)) {
          this.formData.subtotal = 0;
          return;
        }

        const itemTotal = newItems.reduce((total, item) => {
          item.subtotal = (item.quantity || 0) * (item.price || 0);
          return total + item.subtotal;
        }, 0);

        this.formData.subtotal = itemTotal;
      },
      deep: true,
    },

    formData: {
      handler: function (newValue) {
        const { subtotal, discount, paid } = newValue;
        this.formData.total = Number(subtotal) - Number(discount);
        this.formData.due = Number(this.formData.total) - Number(paid);
      },
      deep: true,
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
  },
};
</script>

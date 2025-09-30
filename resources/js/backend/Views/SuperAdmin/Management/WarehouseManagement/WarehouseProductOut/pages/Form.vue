<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">Create WareHouse Product Out</h5>
          <div><!--v-if--><a href="#/ware-house-product-stock/all" class="btn btn-outline-warning btn-sm">All WareHouse Product Stock</a></div>
        </div>
        <div class="card-body card_body_fixed_height">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select sales order </label>
                <div class="mt-1 mb-3">
                  <select
                    class="form-control form-control-square mb-2"
                    name="sales_order_id"
                    id="sales_order_id"
                    v-model="formData.sales_order_id"
                    @change="get_all_product_by_sales_order_id(formData.sales_order_id)"
                  >
                    <option value="">Select sales order</option>
                    <option v-for="item in sales_orders" :key="item" :value="item.id">
                      {{ `${item.title}-${item.reference}` }}
                    </option>
                  </select>
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select Products</label>
                <select name="" id="" class="form-control" @change="set_product_item($event.target.value)" v-model="product_id">
                  <option value="" disabled>Select Product</option>
                  <option
                    v-for="item in products"
                    :value="item.product_id"
                    :key="item.id"
                    
                  >
                    {{ item.product_name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select warehouse </label>
                <div class="mt-1 mb-3">
                  <select class="form-control form-control-square mb-2" name="warehouse_id" id="warehouse_id" v-model="formData.warehouse_id">
                    <option value="" disabled>Select warehouse</option>
                    <option v-for="item in warehouses" :key="item" :value="item.id">
                      {{ item.name.substr(20) }} <span class="text-danger">(Available qty : {{ item.quantity }})</span>
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select date</label>
                <div class="mt-1 mb-3">
                  <input class="form-control form-control-square mb-2" type="date" name="date" id="date" v-model="formData.date" />
                </div>
                <!--v-if--><!--v-if--><!--v-if-->
              </div>
            </div>
          </div>

          <div>
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>quantity</th>
                  <!-- <th>Available for out quantity</th> -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- <tr v-for="(item, index) in formData.product_items" :key="index">
                  <td>
                    <input class="form-control form-control-square" type="hidden" v-model="item.product_id" />
                    <input class="form-control form-control-square" type="text" readonly v-model="item.product_name" />
                  </td>
                  <td>
                    <input class="form-control form-control-square" type="number" v-model="item.quantity" />
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-outline-behance" @click="removeItem(index)">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr> -->
                <tr v-if="formData.product_items">
                  <td>
                    <input class="form-control form-control-square" type="hidden" v-model="formData.product_items.product_id" />
                    <input class="form-control form-control-square" type="text" readonly v-model="formData.product_items.product_name" />
                  </td>
                  <td>
                    <input class="form-control form-control-square" type="number" v-model="formData.product_items.quantity" />
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-outline-behance" @click="removeItem(index)">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-light btn-square px-5 w-25"><i class="icon-lock"></i> Submit</button>
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
import axios from "axios";

export default {
  data: () => ({
    setup,
    form_fields,
    param_id: null,
    warehouses: [],
    sales_orders: [],
    products: [],

    formData: {
      warehouse_id: "",
      sales_order_id: "",
      date: "",
      product_items: {},
    },

    product_id: "",
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    if (id) {
      this.set_fields(id);
    }

    await this.get_all_sales_orders();
  },
  methods: {
    ...mapActions(store, {
      create: "create",
      update: "update",
      details: "details",
      get_all: "get_all",
      set_only_latest_data: "set_only_latest_data",
    }),
    reset_fields: function () {
      this.form_fields.forEach((item) => {
        item.value = "";
      });
    },
    set_fields: async function (id) {
      this.param_id = id;
      await this.details(id);
      if (this.item) {
        this.formData.warehouse_id = this.item.warehouse_id;
        this.formData.sales_order_id = this.item.sales_order_id;
        this.formData.date = this.item.date;

        this.formData.product_items = this.item.ware_house_product_out_products[0];
        this.product_id = this.formData.product_items.product_id

        this.get_all_product_by_sales_order_id(this.formData.sales_order_id);
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

    set_product_item: async function (id) {
      let product = this.products.find((item) => item.product_id == id);

      // Check if the product_id already exists in product_items
      //   if (this.formData.product_items.some((item) => item.product_id == id)) {
      //     alert("Product  already exists ");
      //     return;
      //   }
      this.formData.product_items = {};
      let item = {
        product_id: product.product_id,
        product_name: product.product_name,
        quantity: product.quantity,
      };

      this.formData.product_items = item;
    },
    get_all_product_by_sales_order_id: async function (id) {
      let response = await axios.get(`get-sales-order-products-by-order-id/${id}`);
      if (response.data.status === "success") {
        this.products = response.data?.data;
        console.log(this.formData.product_items);
      }
    },
    removeItem: function (index) {
      this.formData.product_items = this.formData.product_items.filter((item, index2) => index != index2);
    },
    get_all_warehouses: async function () {
      let response = await axios.get("ware-houses");
      if (response.data.status == "success") {
        this.warehouses = response.data?.data?.data || [];
      }
    },
    get_all_sales_orders: async function () {
      let response = await axios.get("sales-orders");
      if (response.data.status == "success") {
        this.sales_orders = response.data?.data?.data || [];
      }
    },

    get_product_relatated_warehouses_by_sales_order_id_and_product_id: async function () {
      if (this.formData.sales_order_id && this.product_id) {
        let response = await axios.get(
          `get-product-related-warehouse-by-order-id-and-product-id?sales_order_id=${this.formData.sales_order_id}&product_id=${this.product_id}`
        );
        if (response.data.status == "success") {
          this.warehouses = response.data.data;
        }
      }
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
  },
  watch: {
    "formData.sales_order_id": {
      handler: function () {
        this.get_product_relatated_warehouses_by_sales_order_id_and_product_id();
      },
    },
    product_id: {
      handler: function () {
        this.get_product_relatated_warehouses_by_sales_order_id_and_product_id();
      },
    },
  },
};
</script>

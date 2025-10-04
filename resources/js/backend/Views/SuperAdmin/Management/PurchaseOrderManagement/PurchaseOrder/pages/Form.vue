<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">Create PurchaseOrder</h5>
          <div>
            <!--v-if--><a
              href="#/purchase-order/all"
              class="btn btn-outline-warning btn-sm"
              >All PurchaseOrder</a
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
           
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Slect suppliyer</label>
                <div class="mt-1 mb-3">
                  <select
                    class="form-control form-control-square mb-2"
                    name="suppliyer_id"
                    id="suppliyer_id"
                    v-model="formData.suppliyer_id"
                  >
                    <option value="">Select suppliyer</option>
                    <option
                      v-for="item in suppliyers"
                      :key="item"
                      :value="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
           
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
           
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select your currency</label>
                <div class="mt-1 mb-3">
                  <select
                    class="form-control form-control-square mb-2"
                    name="currency_id"
                    id="currency_id"
                    v-model="formData.currency_id"
                  >
                    <option value="1">Chinese Yuan</option>
                    <option value="2">BDT</option>
                    <option value="3">USD</option>
                  </select>
                </div>
           
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Enter your currency exchange rate</label>
                <div class="mt-1 mb-3">
                  <input
                    class="form-control form-control-square mb-2"
                    type="number"
                    step="any"
                    min="0"
                    name="currency_exchange_rate"
                    id="currency_exchange_rate"
                    v-model="formData.currency_exchange_rate"
                  />
                </div>
           
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Enter your expected time of delivery</label>
                <div class="mt-1 mb-3">
                  <input
                    class="form-control form-control-square mb-2"
                    type="date"
                    name="expected_time_of_delivery"
                    id="expected_time_of_delivery"
                    v-model="formData.expected_time_of_delivery"
                  />
                </div>
           
              </div>
            </div>
          </div>
          <div class="row justify-content-center my-3">
            <div class="col-md-7">
              <div class="form-group">
                <label for="">Select Products</label>
                <div class="position-relative">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search and select product..."
                    v-model="productSearch"
                    @focus="showProductDropdown = true"
                    @blur="hideProductDropdown"
                    autocomplete="off"
                  />
                  <div
                    v-if="showProductDropdown && filteredProducts.length > 0"
                    class="dropdown-menu show w-100"
                    style="max-height: 200px; overflow-y: auto; position: absolute; top: 100%; z-index: 1000;"
                  >
                    <a
                      href="#"
                      class="dropdown-item"
                      v-for="item in filteredProducts"
                      :key="item.id"
                      @mousedown="selectProduct(item)"
                    >
                      {{ item.title }}
                    </a>
                  </div>
                  <div
                    v-if="showProductDropdown && filteredProducts.length === 0 && productSearch"
                    class="dropdown-menu show w-100"
                    style="position: absolute; top: 100%; z-index: 1000;"
                  >
                    <span class="dropdown-item-text">No products found</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <!-- <th>Currency</th> -->
                  <th>SubTotal In BDT</th>
                  <th>SubTotal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in product_items" :key="index">
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
                      step="any"
                      min="0"
                      v-model="item.quantity"
                    />
                  </td>
                  <td>
                    <input
                      class="form-control form-control-square"
                      type="number"
                      step="any"
                      min="0"
                      v-model="item.price"
                    />
                  </td>
                  <!-- <td>
                    <select
                      v-model="item.currency_id"
                      class="form-control form-control-square"
                    >
                      <option value="1">Chinese Yuan</option>
                      <option value="2">BDT</option>
                      <option value="3">USD</option>
                    </select>
                  </td> -->
                  <td>
                    <input
                      class="form-control form-control-square"
                      type="text"
                      v-model="item.subtotal_in_bdt"
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
                        step="any"
                        readonly
                        v-model="update_total_price.subtotal"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Total in BDT</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        step="any"
                        readonly
                        v-model="update_total_price.total_in_bdt"
                      />
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2">Ohter Cost</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        step="any"
                        min="0"
                        v-model="update_total_price.other_cost"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Discount</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        step="any"
                        min="0"
                        v-model="update_total_price.discount"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Grand Total</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        type="number"
                        step="any"
                        readonly
                        v-model="update_total_price.total"
                      />
                    </td>
                  </tr>
                  <tr >
                    <td colspan="2">Paid</td>
                    <td>
                      <input
                        class="form-control form-control-square"
                        :readonly="param_id ? true : false"
                        required
                        type="number"
                        step="any"
                        min="0"
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
                        step="any"
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
    form_fields,
    param_id: null,
    products: [],
    suppliyers: [],
    product_items: [],
    productSearch: "",
    showProductDropdown: false,
    formData: {
      title: "",
      reference: "",
      suppliyer_id: "",
      date: "",
      currency_id: 1,
      currency_exchange_rate: 0,
      expected_time_of_delivery: "",
      paid: 0,
      due: 0,
    },

    update_total_price: {
      subtotal: 0,
      discount: 0,
      other_cost: 0,
      total: 0,
      total_in_bdt: 0,
    },
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    if (id) {
      this.set_fields(id);
    }

    await this.get_all_products();
    await this.get_all_suppliyers();
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

        this.formData.title = this.item.title;
        this.formData.reference = this.item.reference;
        this.formData.suppliyer_id = this.item.suppliyer_id;
        this.formData.date = this.item.date;
        this.formData.currency_id = this.item.currency_id;
        this.formData.currency_exchange_rate = this.item.currency_exchange_rate;
        this.formData.expected_time_of_delivery =
          this.item.expected_time_of_delivery;
        this.formData.paid = this.item.paid;
        this.formData.due = this.item.due;

        this.update_total_price.subtotal = this.item.subtotal;
        this.update_total_price.discount = this.item.discount;
        this.update_total_price.other_cost = this.item.other_cost;
        this.update_total_price.total = this.item.total;
        this.update_total_price.total_in_bdt = this.item.total_in_bdt;

        this.product_items = this.item.purchase_order_products;
        
      }
    },

    submitHandler: async function ($event) {
      this.set_only_latest_data(true);
      if (this.param_id) {
        let form_data = {
          ...this.formData,
          product_items: this.product_items,
          update_total_price: this.update_total_price,
        };
        let response = await this.update(form_data);
        // await this.get_all();
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data successfully updated");
          this.$router.push({
            name: `All${this.setup.route_prefix}`,
          });
        }
      } else {
        let form_data = {
          ...this.formData,
          product_items: this.product_items,
          update_total_price: this.update_total_price,
        };
        let response = await this.create(form_data);
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

    set_product_item: function (id) {
      let product = this.products.find((item) => item.id == id);

      // Check if the product_id already exists in product_items
      if (this.product_items.some((item) => item.product_id == id)) {
        alert("Product  already exists ");
        return;
      }

      this.product_items.push({
        product_id: product.id,
        product_name: product.title,
        quantity: 0,
        price: 0,
        currency_id: 1,
        subtotal_in_bdt: 0,
        subtotal: 0,
      });
    },
    removeItem: function (index) {
      this.product_items = this.product_items.filter(
        (item, index2) => index != index2
      );
      if (this.product_items.length === 0) {
        this.update_total_price = {
          subtotal: 0,
          discount: 0,
          other_cost: 0,
          total: 0,
          total_in_bdt: 0,
        };
      }
    },
    get_all_suppliyers: async function () {
      let response = await axios.get("suppliyers?get_all=1");
      if (response.data.status == "success") {
        this.suppliyers = response.data?.data || [];
      }
    },

    recalculateProductItems() {
      const itemTotal = this.product_items.reduce((total, item) => {
        // Recalculate subtotal and subtotal_in_bdt for each item
        item.subtotal = item.quantity * item.price;
        item.subtotal_in_bdt =
          Number(item.subtotal) * Number(this.formData.currency_exchange_rate); // Conversion logic
        return total + item.subtotal;
      }, 0);

      // Update the total in update_total_price
      this.update_total_price.subtotal = itemTotal;
      this.update_total_price.total_in_bdt =
        Number(itemTotal) * Number(this.formData.currency_exchange_rate);
    },

    // Method to recalculate update_total_price
    recalculateUpdateTotalPrice() {
      const { subtotal, discount, other_cost } = this.update_total_price;
      this.update_total_price.total =
        Number(subtotal) + Number(other_cost) - Number(discount);
    },
    calculateDue() {
      this.formData.due = this.formData.paid - this.update_total_price.total;
    },

    selectProduct: function (product) {
      // Check if the product_id already exists in product_items
      if (this.product_items.some((item) => item.product_id == product.id)) {
        alert("Product already exists");
        this.productSearch = "";
        this.showProductDropdown = false;
        return;
      }

      this.product_items.push({
        product_id: product.id,
        product_name: product.title,
        quantity: 0,
        price: 0,
        currency_id: 1,
        subtotal_in_bdt: 0,
        subtotal: 0,
      });

      // Clear search and hide dropdown
      this.productSearch = "";
      this.showProductDropdown = false;
    },

    hideProductDropdown: function () {
      // Add a small delay to allow clicking on dropdown items
      setTimeout(() => {
        this.showProductDropdown = false;
      }, 200);
    }
  },

  watch: {
    product_items: {

      handler(newItems) {
        // Calculate the total subtotal for all items
        const itemTotal = newItems.reduce((total, item) => {
          item.subtotal = item.quantity * item.price;
          item.subtotal_in_bdt =
            Number(item.subtotal) *
            Number(this.formData.currency_exchange_rate); // Conversion logic if needed
          return total + item.subtotal;
        }, 0);

        // Update the total in update_total_price
        this.update_total_price.subtotal = itemTotal;
        this.update_total_price.total_in_bdt =
          Number(itemTotal) * Number(this.formData.currency_exchange_rate);

          this.calculateDue();
      },
      deep: true,
    },

    update_total_price: {
      handler: function (newValue) {
        const { subtotal, discount, other_cost } = newValue;
        this.update_total_price.total =
          Number(subtotal) + Number(other_cost) - Number(discount);

          this.calculateDue();
      },
      deep: true,
    },

    "formData.currency_exchange_rate": {
      handler() {
        this.recalculateProductItems();
        this.recalculateUpdateTotalPrice();
      },
      deep: true,
    },

    "formData.paid": {
      handler: function (newValue) {
        this.formData.due =
          Number(this.update_total_price.total) - Number(newValue);
      },
      deep: true,
    },
    "update_total_price.other_cost": {
      handler: function () {
        this.calculateDue();
      },
      deep: true,
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
    
    filteredProducts() {
      if (!this.productSearch) {
        return this.products;
      }
      return this.products.filter(product =>
        product.title.toLowerCase().includes(this.productSearch.toLowerCase())
      );
    }
  },
};
</script>

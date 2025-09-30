<template>
  <div>
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="text-capitalize">
         Warehouse Product List
        </h5>
        <div>
          <router-link class="btn btn-outline-warning btn-sm" :to="{ name: `All${setup.route_prefix}` }">
            {{ setup.all_page_title }}
          </router-link>
        </div>
      </div>
    
      <div class="card-body">
        <div class="table-responsive table_responsive card_body_fixed_height">
          <table class="table table-hover text-center table-bordered">
            <thead>
              <tr>
                <th class="w-10 text-center">Product Id</th>
                <th class="w-10 text-center">Product Name</th>
                <th class="w-10 text-center">Product Stock Quantity</th>
                <th class="w-10 text-center">Image</th>
              </tr>
            </thead>
            <tbody v-if="product_lists?.length">
              <tr  v-for="(item, index) in product_lists" :key="index">
                <th class="w-10 text-center">{{ item.id }}</th>
                <th>{{ item.title }}</th>
                <th class="w-10 text-center">
                  {{ item.total_stock_quantity }}
                </th>
                <th class="w-10 text-center">
                  <img v-if="item.image" :src="item.image" alt="" style="height: 130px" />
                </th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    
    </div>
  </div>
</template>

<script>
import { mapActions, mapState, mapWritableState } from "pinia";
import { store } from "../store";
import setup from "../setup";
import DataDetialsTableBody from "../components/all_data_page/DataDetialsTableBody.vue";
export default {
  components: {
    DataDetialsTableBody,
  },
  data: () => ({
    setup,
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    await this.get_data(id);
  },
  methods: {
    ...mapActions(store, {
      get_warehouse_wise_product_lists: "get_warehouse_wise_product_lists",
    }),
    get_data: async function (slug) {
      this.item = {};
      await this.get_warehouse_wise_product_lists(slug);
    },
  },
  computed: {
    ...mapWritableState(store, {
      product_lists: "product_lists",
    }),
  },
};
</script>

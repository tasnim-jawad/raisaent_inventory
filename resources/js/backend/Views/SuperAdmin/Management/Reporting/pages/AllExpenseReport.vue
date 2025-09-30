<template>
    <div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <!-- Title Section -->
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                  <h5 class="text-capitalize mb-0"> Expense Report</h5>
                </div>
                <!-- Search Input -->
  
                <!-- Sorting Button -->
                <div class="col-12 col-md-3 text-md-right text-sm-left">
                  <button
                    v-if="expense_data?.data?.length"
                    class="btn btn-outline-success btn-sm"
                    @click.prevent="() => export_all_csv(expense_data?.data)"
                  >
                    <i class="fa fa-gear mx-2"></i> Export All
                  </button>
                  <button class="btn btn-outline-success btn-sm mx-2" @click="set_show_filter_canvas"><i class="fa fa-gear mx-2"></i>Filter</button>
                </div>
              </div>
            </div>
  
            <div class="card-body">
              <div class="table-responsive table_responsive card_body_fixed_height">
                <table class="table table-hover text-center table-bordered">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in expense_data.data" :key="item">
                      <td>{{ item.account_category.title }}</td>
                      <td>{{ item.title }}</td>
                      <td>{{ item.amount }}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2" class="text-end">Amount</td>
                      <td>
                        {{ expense_data.total }}
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="off_canvas data_filter" :class="`${show_filter_canvas ? 'active' : ''}`">
        <div class="off_canvas_body">
          <div class="header">
            <h3 class="heading_text">Filter</h3>
            <button class="close_button" @click="set_show_filter_canvas(false)">
              <span class="fa fa-close border p-2"></span>
            </button>
          </div>
          <div class="data_content">
            <div class="filter_item">
              <label for="start_date">Start Date</label>
              <label for="start_date" class="text-capitalize d-block date_custom_control">
                <input v-model="start_date" type="date" id="start_date" name="start_date" class="form-control" />
                <!-- <div class="form-control preview"></div> -->
              </label>
            </div>
            <div class="filter_item">
              <label for="end_date">End Date</label>
              <label for="end_date" class="text-capitalize d-block date_custom_control">
                <input v-model="end_date" type="date" id="end_date" name="end_date" class="form-control" />
                <!-- <div class="form-control preview"></div> -->
              </label>
            </div>
  
            <div class="filter_item">
              <button @click.prevent="get_all_expense_report()" type="button" class="btn btn-sm btn-outline-info">Submit</button>
            </div>
          </div>
        </div>
        <div class="off_canvas_overlay"></div>
      </div>
    </div>
  </template>
  
  <script>
  /** plugins */
  import { mapActions, mapWritableState } from "pinia";
  import { store as data_store } from "../store";
  import export_all_csv from "../helpers/export_all_csv";
  export default {
    components: {},
  
    data: () => ({
      expense_data: [],
      start_date: "",
      end_date: "",
    }),
    created: async function () {
      await this.get_all_expense_report();
    },
    methods: {
      export_all_csv,
      ...mapActions(data_store, ["set_show_filter_canvas"]),
      get_all_expense_report: async function () {
        let response = await axios.get(`get-all-expense-report?start_date=${this.start_date}&end_date=${this.end_date}`);
        console.log(response);
  
        if (response.data.status == "success") {
          this.expense_data = response.data.data;
        }
      },
    },
    computed: {
      ...mapWritableState(data_store, ["show_filter_canvas"]),
    },
  
    watch: {
      start_date(value) {
        this.start_date = value;
      },
      end_date(value) {
        this.end_date = value;
      },
    },
  };
  </script>
  
  <style scoped>
  .table_responsive table tfoot {
    position: sticky;
    bottom: 0;
    left: 0;
    z-index: 8;
    background-color: #162635;
    backdrop-filter: blur(4px);
  }
  .text-end {
    text-align: end !important;
  }
  </style>
  
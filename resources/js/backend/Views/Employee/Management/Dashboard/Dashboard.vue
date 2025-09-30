<template>
  <div class="container-fluid">
    <!--Start Dashboard Content-->

    <div class="card mt-3">
      <div class="card-content">
        <div class="row row-group m-0">
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalIncomes }}
                <!-- <span class="float-right"><i class="fa fa-users"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Income
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalExpenses }}
                <!-- <span class="float-right"><i class="fa fa-book"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Expenses
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalProducts }}
                <!-- <span class="float-right"><i class="fa fa-eye"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Products
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalPurchaseOrders }}
                <!-- <span class="float-right"><i class="fa fa-envira"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Purchase Orders
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-content">
        <div class="row row-group m-0">
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalSuppliers }}
                <!-- <span class="float-right"><i class="fa fa-users"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Suppliers
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalWarehouses }}
                <!-- <span class="float-right"><i class="fa fa-book"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Warehouses
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalCustomers }}
                <!-- <span class="float-right"><i class="fa fa-eye"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Customers
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body">
              <h5 class="text-white mb-0">
                {{ data.getTotalSalesOrders }}
                <!-- <span class="float-right"><i class="fa fa-envira"></i></span> -->
              </h5>
              <div class="progress my-3" style="height: 3px">
                <!-- <div class="progress-bar" style="width: 55%"></div> -->
              </div>
              <p class="mb-0 text-white small-font">
                Total Sales Orders
                <span class="float-right">
                  <!-- <i class="zmdi zmdi-long-arrow-up"></i> -->
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--End Row-->

    <!--End Dashboard Content-->
    <!--start overlay-->
    <div class="overlay"></div>
    <!--end overlay-->
  </div>
  <!-- End container-fluid-->
</template>

<script>
export default {
  data: () => ({
    data: {},
  }),
  created: async function () {
    await this.get_all_dashboard_data();
  },
  methods: {
    get_all_dashboard_data: async function () {
      let response = await axios.get("get-all-dashboard-data");
      if (response.status == 200) {
        this.data = response.data.data;
      }
    },
  },
};
</script>

<style></style>

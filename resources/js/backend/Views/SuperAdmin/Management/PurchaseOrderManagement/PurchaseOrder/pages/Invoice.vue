<template>
  <div>
    <div class="container card">
      <!-- Header Section -->
      <div class="bill-header">
        <h2 class="bill-title">BAIYUAN MACHINERY CO.</h2>
        <p>
          House # 20, Road # 33, Sector # 07, Uttara, Dhaka-1230, Bangladesh
        </p>
        <p>
          <strong>Phone:</strong> +880 17676 88801, +880 1949323555<br />
          <strong>Email:</strong> baiyuanbd@gmail.com
        </p>
        <hr />
      </div>

      <!-- Bill Information -->
      <div class="bill-info">
        <div class="d-flex justify-content-between">
          <div>
            <strong>Bill No: </strong>
            <span class="underline">{{ item.id }}</span>
          </div>
          <div>
            <strong>Challan No: </strong>
            <span class="underline">{{ item.order_id }}</span>
          </div>
          <div>
            <strong>Date: </strong>
            <span class="underline">{{ item.date }}</span>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-3 gap-2">
          <div>
            <strong>Name: </strong>
            <span class="underline">{{ item.suppliyer?.name }}</span>
          </div>
          <div class="text-start">
            <strong>Address:</strong>
            <span class="underline">{{ item.address ?? "N/A" }}</span>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="border border-top-0 border-right-0 border-left-0">
        <table class="table table-bordered mt-4">
          <thead>
            <tr>
              <th>NO.</th>
              <th>DESCRIPTION OF GOODS</th>
              <th>QUANTITY</th>
              <th>UNIT PRICE</th>
              <th>TOTAL PRICE</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in item.purchase_order_products">
              <td>{{ index + 1 }}</td>
              <td>{{ data.product_name }}</td>
              <td>{{ data.quantity }}</td>
              <td>{{ data.price }}</td>
              <td>{{ data.subtotal }}</td>
            </tr>

            <tr></tr>
            <tr>
              <td colspan="3" class="text-left py-4">
                <strong>
                  Taka in Words:
                  <span class="underline text-capitalize">{{
                    convert_amount(Number(item.total))
                  }}</span>
                </strong>
              </td>
              <td class="text-right">
                <strong>Total Amount:</strong>
              </td>
              <td>{{ item.total }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Footer Section -->
      <div class="footer-section">
        <div class="d-flex justify-content-between my-5">
          <div>
            <p>__________________________</p>
            <p><strong>Received by:</strong></p>
          </div>
          <div class="text-right">
            <p>__________________________</p>
            <p>For: Baiyuan Machinery Co.</p>
          </div>
        </div>
      </div>
    </div>
    <button
      class="btn btn-primary print-btn my-3 text-center mx-auto d-block"
      @click="print"
    >
      Print
    </button>
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
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    if (id) {
      await this.details(id);
    }
  },
  methods: {
    ...mapActions(store, {
      details: "details",
    }),
    print() {
      window.print();
    },
    convert_amount: function (params) {
      return convert(params) ?? 0;
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
  },
};
</script>

<style>
body {
  font-family: Arial, sans-serif;
}
.bill-header {
  text-align: center;
  margin-bottom: 20px;
}
.bill-header img {
  max-width: 100px;
}
.bill-title {
  font-size: 1.5rem;
  font-weight: bold;
}
.bill-info {
  margin-bottom: 20px;
}
.table th,
.table td {
  vertical-align: middle;
  text-align: center;
}
.footer {
  margin-top: 20px;
  font-size: 0.9rem;
}

.underline {
  text-decoration: underline;
  text-underline-offset: 4px; /* Adjust the space between text and underline */
}

@media print {
  #sidebar-wrapper {
    display: none !important;
  }
  .topbar-nav {
    display: none;
  }
  .content-wrapper {
    margin-left: 0;
  }

  body,
  table,
  td,
  tr,
  p,
  h2 {
    color: black !important;
  }

  .switcher-icon {
    display: none !important;
  }
  .print-btn {
    display: none !important;
  }
}
</style>

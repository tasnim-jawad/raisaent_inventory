<template>
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div
              class="table-responsive table_responsive card_body_fixed_height"
            >
              <table class="table table-bordered text-white">
                <thead>
                  <tr>
                    <th colspan="4" class="text-center">
                      <h4>Income Expense Report</h4>
                    </th>
                  </tr>
                  <!-- <tr>
                    <td>মাসের নাম</td>
                    <td colspan="2" class="text-center">January</td>
                    <td class="text-end">সাল</td>
                  </tr> -->
                  <tr>
                    <td class="w-25">date</td>
                    <td colspan="2" class="w-50">
                      <input
                        v-model="start_date"
                        type="date"
                        class="income_expense_date_field"
                      />
                      To
                      <input
                        v-model="end_date"
                        type="date"
                        class="income_expense_date_field"
                      />
                    </td>
                    <td class="w-25">{{ year }}</td>
                  </tr>
                  <tr>
                    <th class="w-50" colspan="2">Income</th>
                    <th class="w-50" colspan="2">Expense</th>
                  </tr>
                  <tr class="row_sticky">
                    <th>description</th>
                    <th>amount</th>
                    <th>description</th>
                    <th>amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in income_expense_data.rows" :key="item">
                    <td>{{ item.income_category.substr(50) }}</td>
                    <td>{{ item.income_amount }}</td>
                    <td>{{ item.expense_category.substr(50) }}</td>
                    <td>{{ item.expense_amount }}</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td>total income :</td>
                    <td class="fw-bold">
                      {{ income_expense_data.totalIncome }}
                    </td>
                    <td class="fw-bold">total expense :</td>
                    <td>{{ income_expense_data.totalExpense }}</td>
                  </tr>

                  <tr>
                    <td></td>
                    <td colspan="2" class="fw-bold">
                      total surplus : {{ income_expense_data.surplus }}
                    </td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/** plugins */

export default {
  data: () => ({
    income_expense_data: [],
    start_date: moment().subtract(1, "month").format("YYYY-MM-DD"), // Assign today's date
    end_date: moment().format("YYYY-MM-DD"), // Assign today's date
    year: moment().year(),
  }),
  created: async function () {
    await this.get_all_income_expense_report();
  },
  methods: {
    get_all_income_expense_report: async function () {
      let response = await axios.get(
        `get-all-income-expense-report?start_date=${this.start_date}&end_date=${this.end_date}`
      );

      if (response.data.status == "success") {
        this.income_expense_data = response.data.data;
      }
    },
  },
  watch: {
    start_date(value) {
      this.start_date = value;
      this.get_all_income_expense_report();
    },
    end_date(value) {
      this.end_date = value;
      this.get_all_income_expense_report();
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
.card_body_fixed_height {
  height: calc(100vh) !important;
  overflow-y: auto !important;
}
</style>

<template>
    <div>
        <form @submit.prevent="submitHandler">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-capitalize">
                        {{ setup.prefix }} Log History
                    </h5>
                    <div>
                        <form
                            @submit.prevent="LogSearchHandler"
                            class="d-flex justify-content-evenly align-items-center"
                        >
                            <input
                                type="date"
                                class="form-control"
                                name="start_date"
                                id=""
                            />
                            <input
                                type="date"
                                class="form-control mx-2"
                                name="end_date"
                                id=""
                            />
                            <button
                                type="submit"
                                class="btn btn-outline-success"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div>
                        <router-link
                            class="btn btn-outline-warning btn-sm"
                            :to="{ name: `All${setup.route_prefix}` }"
                        >
                            {{ setup.all_page_title }}
                        </router-link>
                    </div>
                </div>
                <div class="card-body card_body_fixed_height">
                    <div class="row gap-2 justify-content-center">
                        <div
                            class="col-lg-6 my-2 p-2 border rounded-3"
                            v-for="(item, index) in sales_order_logs"
                            :key="index"
                        >
                            <div class="d-flex flex-wrap gap-1">
                                <div class="w-25">
                                    <label for="">created date</label>
                                    <div class="">
                                        <input
                                            class="form-control form-control-square mb-2"
                                            readonly
                                            :value="
                                                new Date(
                                                    item.created_at
                                                ).toDateString()
                                            "
                                        />
                                    </div>
                                </div>
                                <div class="w-25">
                                    <label for="">title</label>
                                    <div class="">
                                        <input
                                            class="form-control form-control-square mb-2"
                                            readonly
                                            :value="item.title"
                                        />
                                    </div>
                                </div>
                                <div class="w-25">
                                    <label for="">Reference</label>
                                    <div class="">
                                        <input
                                            class="form-control form-control-square mb-2"
                                            readonly
                                            :value="item.reference"
                                        />
                                    </div>
                                </div>
                                <div class="w-25">
                                    <label for="">customer_id</label>
                                    <div class="">
                                        <input
                                            class="form-control form-control-square mb-2"
                                            readonly
                                            :value="item.customer_id"
                                        />
                                    </div>
                                </div>




                            </div>
                            <table
                                class="table quick_modal_table table-bordered"
                            >
                                <tbody>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>SubTotal</th>

                                    </tr>
                                    <tr
                                        v-for="product in item.sales_order_products"
                                        :key="product.id"
                                    >
                                        <td>{{ product.product_name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.price }}</td>
                                        <td>{{ product.subtotal }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
        sales_order_logs: [],
    }),
    created: async function () {
        let id = (this.param_id = this.$route.params.id);
        await this.get_data(id);

        this.sales_order_logs = this.item.sales_order_logs;
    },
    methods: {
        ...mapActions(store, {
            details: "details",
        }),
        get_data: async function (slug) {
            this.item = {};
            await this.details(slug);
        },
        LogSearchHandler: async function (e) {
            let id = (this.param_id = this.$route.params.id);
            let formData = new FormData(e.target);
            formData.append("slug", id);
            let response = await axios.post(
                `/sales-orders/log-search`,
                formData
            );
            if (response.data.status == "success") {
                this.sales_order_logs = response.data.data;
                console.log(this.item);
            }
        },
    },
    computed: {
        ...mapWritableState(store, {
            item: "item",
        }),
    },
};
</script>

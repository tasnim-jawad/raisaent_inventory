<template>
    <div>
        <form @submit.prevent="submitHandler">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-capitalize">
                        {{
                            param_id
                                ? `${setup.edit_page_title}`
                                : `${setup.create_page_title}`
                        }}
                    </h5>
                    <div>
                        <router-link
                            v-if="item.slug"
                            class="btn btn-outline-info mr-2 btn-sm"
                            :to="{
                                name: `Details${setup.route_prefix}`,
                                params: { id: item.slug },
                            }"
                        >
                            {{ setup.details_page_title }}
                        </router-link>
                        <router-link
                            class="btn btn-outline-warning btn-sm"
                            :to="{ name: `All${setup.route_prefix}` }"
                        >
                            {{ setup.all_page_title }}
                        </router-link>
                    </div>
                </div>
                <div class="card-body card_body_fixed_height">
                    <div class="row">
                        <template
                            v-for="(form_field, index) in form_fields"
                            v-bind:key="index"
                        >
                            <common-input
                                :label="form_field.label"
                                :type="form_field.type"
                                :name="form_field.name"
                                :multiple="form_field.multiple"
                                :value="form_field.value"
                                :data_list="form_field.data_list"
                                :is_visible="form_field.is_visible"
                                :row_col_class="form_field.row_col_class"
                                :onchange="changeAction"
                                :onchangeAction="form_field.onchangeAction"
                            />
                        </template>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-light btn-square px-5">
                        <i class="icon-lock"></i>
                        Submit
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
    }),
    created: async function () {
        let id = (this.param_id = this.$route.params.id);
        this.reset_fields();
        if (id) {
            this.set_fields(id);
        }

        this.get_all_suppliyers();
        this.get_all_categories();
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
                this.form_fields.forEach((field, index) => {
                    Object.entries(this.item).forEach((value) => {
                        if (field.name == value[0]) {
                            this.form_fields[index].value = value[1];
                        }
                        if (
                            field.name == "description" &&
                            value[0] == "description"
                        ) {
                            $("#description").summernote("code", value[1]);
                        }

                        if (
                            field.name == "product_category_id" &&
                            value[0] == "product_category_id"
                        ) {
                            console.log(value[1]);

                            this.get_sub_category(value[1]);
                        }
                    });
                });
            }
        },

        submitHandler: async function ($event) {
            this.set_only_latest_data(true);
            if (this.param_id) {
                this.setSummerEditor();
                let response = await this.update($event);
                // await this.get_all();
                if ([200, 201].includes(response.status)) {
                    window.s_alert("Data successfully updated");
                    this.$router.push({
                        name: `Details${this.setup.route_prefix}`,
                    });
                }
            } else {
                this.setSummerEditor();
                let response = await this.create($event);
                // await this.get_all();
                if ([200, 201].includes(response.status)) {
                    window.s_alert("Data Successfully Created");
                    this.$router.push({
                        name: `All${this.setup.route_prefix}`,
                    });
                }
            }
        },
        get_all_suppliyers: async function () {
            let response = await axios.get("suppliyers?get_all=1");
            if (response.data.status == "success") {
                const suppliyers = response.data?.data || [];
                this.form_fields[1].data_list = suppliyers.map((suppliyer) => ({
                    label: suppliyer.name,
                    value: suppliyer.id,
                }));
            }
        },
        get_all_categories: async function () {
            let response = await axios.get("product-categories?get_all=1");
            if (response.data.status == "success") {
                const categories = response.data?.data || [];
                this.form_fields[2].data_list = categories.map((category) => ({
                    label: category.title,
                    value: category.id,
                }));
            }
        },
        changeAction: function (actionTitle, event, ref) {
            this[actionTitle](actionTitle, event, ref);
        },
        get_product_sub_category_by_category_id: async function (
            actionTitle,
            event,
            ref
        ) {
            let category_id = event.target.value;
            this.get_sub_category(category_id);
        },

        get_sub_category: async function (category_id) {
            let response = await axios.get(
                `get-all-sub-category-by-category-id/${category_id}?get_all=1`
            );
            if (response.data.status == "success") {
                const categories = response.data?.data || [];
                this.form_fields[3].data_list = categories.map((category) => ({
                    label: category.title,
                    value: category.id,
                }));
            }
        },

        setSummerEditor() {
            var markupStr = $("#description").summernote("code");
            var target = document.createElement("input");
            target.setAttribute("name", "description");
            target.value = markupStr;
            document.getElementById("description").appendChild(target);
        },
    },

    computed: {
        ...mapState(store, {
            item: "item",
        }),
    },
};
</script>

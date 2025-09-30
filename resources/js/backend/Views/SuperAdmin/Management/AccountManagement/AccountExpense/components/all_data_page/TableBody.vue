<template>
    <tr
        v-for="item in data"
        :key="item.id"
        :class="`table_rows table_row_${item.id}`"
    >
        <td>
            <table-row-action :item="item"></table-row-action>
        </td>
        <td>
            <select-single :data="item" />
        </td>

        <td class="text-wrap max-w-120">
            {{ item.id }}
        </td>
        <td class="text-wrap max-w-120">
            {{ item.account_category?.title ?? "N/A" }}
        </td>
        <td class="text-wrap max-w-120">
            {{ item.title ?? "N/A" }}
        </td>
        <td class="text-wrap max-w-120">
            {{ item.amount ?? "N/A" }}
        </td>
        <td class="text-wrap max-w-120">
            {{ item.is_approved == 1 ? "Approved" : "Pending" }}
        </td>
        <td class="text-wrap max-w-120">
            {{ item.created_at }}
        </td>
    </tr>
</template>

<script>
import setup from "../../setup";
import SelectAll from "./select_data/SelectAll.vue";
import TableRowAction from "./TableRowAction.vue";
import SelectSingle from "./select_data/SelectSingle.vue";
export default {
    props: ["data"],
    data: () => ({
        setup,
    }),
    components: {
        SelectAll,
        TableRowAction,
        SelectSingle,
    },

    methods: {
        updateStatus: async function (slug) {
            let is_approved = event.target.checked;
            let response = await axios.post(
                "account-expenses/update-status?is_approved_status=1",
                {
                    slug: slug,
                    is_approved: is_approved,
                }
            );
        },
    },
};
</script>

<style scoped>
.max-w-120 {
    max-width: 120px;
}
</style>

<template>
  <!-- {{ item }} -->

  <template v-for="(row_item, index) in setup.table_row_data" :key="index">
    <tr>
      <th>{{ row_item }}</th>
      <th class="text-center">:</th>
      <th class="text-trim">
        <template v-if="row_item == 'image' && item[row_item]">
          <img class="max-w-120" :src="item[row_item]" alt="" />
        </template>
        <template v-else>
          {{ trim_content(item[row_item], row_item) }}
        </template>
      </th>
    </tr>
  </template>
</template>

<script>
import setup from "../../setup";
import SelectAll from "./select_data/SelectAll.vue";
import TableRowAction from "./TableRowAction.vue";
import SelectSingle from "./select_data/SelectSingle.vue";
export default {
  props: ["item"],
  data: () => ({
    setup,
  }),
  components: {
    SelectAll,
    TableRowAction,
    SelectSingle,
  },

  methods: {
    trim_content(content, row_item = null) {
      if (typeof content == "string") {
        if (row_item == "created_at" || row_item == "updated_at") {
          return new Date(content).toLocaleTimeString();
        }

        return content.length > 50 ? content.substring(0, 50) + "..." : content;
      }
      if (content && typeof content === "object") {
        for (const key of Object.keys(content)) {
          if (key === "title" && content.title) {
            return content.title.length > 50
              ? content.title.substring(0, 50) + "..."
              : content.title;
          }
          if (key === "name" && content.name) {
            return content.name.substring(0, 20) + "...";
          }
        }
      }
      return content;
    },
  },
};
</script>

<style scoped>
.max-w-120 {
  max-width: 120px;
}
</style>

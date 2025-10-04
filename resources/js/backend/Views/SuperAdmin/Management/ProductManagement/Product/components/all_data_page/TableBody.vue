<template>
  <tr
    v-for="(item, dataindex) in data"
    :key="item.id"
    :class="`table_rows table_row_${item.id}`"
  >
    <td>
      <table-row-action :item="item"></table-row-action>
    </td>
    <td>
      <select-single :data="item" />
    </td>
    <template v-for="(row_item, index) in dynamicTableRowData" :key="index">
      <td v-if="row_item == 'id'">{{ dataindex + 1 }}</td>
      <td v-else-if="row_item.startsWith('warehouse_stock_')" class="text-center">
        <span class="badge" :class="getStockBadgeClass(getWarehouseStock(item, row_item))">
          {{ getWarehouseStock(item, row_item) }}
        </span>
      </td>
      <td v-else-if="row_item == 'total_stock_quantity'" class="text-center">
        <span class="badge badge-primary">
          {{ item.warehouse_stock_details?.total_stock || 0 }}
        </span>
      </td>
      <td v-else class="text-wrap max-w-120">
        <template v-if="row_item == 'image' && item[row_item]">
          <img width="70" :src="item[row_item]" alt="" />
        </template>
        <template v-else>
          {{ trim_content(item[row_item], row_item) }}
        </template>
      </td>
    </template>
  </tr>
</template>

<script>
import setup from "../../setup";
import SelectAll from "./select_data/SelectAll.vue";
import TableRowAction from "./TableRowAction.vue";
import SelectSingle from "./select_data/SelectSingle.vue";
import { mapWritableState } from 'pinia';
import { store as data_store } from '../../store';

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
  computed: {
    ...mapWritableState(data_store, [
      'warehouses',
    ]),
    dynamicTableRowData() {
      const baseRowData = [
        "id",
        "title",
        "suppliyer",
        "product_category", 
        "product_sub_category",
        "total_stock_quantity",
      ];
      
      // Add warehouse stock columns - ensure warehouses is loaded and is an array
      const warehouseRowData = (this.warehouses && Array.isArray(this.warehouses)) 
        ? this.warehouses.map(warehouse => `warehouse_stock_${warehouse.id}`)
        : [];
      
      const endRowData = [
        "status",
        "created_at",
        "image"
      ];
      
      return [...baseRowData, ...warehouseRowData, ...endRowData];
    }
  },
  methods: {
    getWarehouseStock(item, warehouseKey) {
      const warehouseId = parseInt(warehouseKey.replace('warehouse_stock_', ''));
      const warehouseDetails = item.warehouse_stock_details?.warehouse_details || [];
      
      const warehouseData = warehouseDetails.find(detail => 
        detail.warehouse_id === warehouseId
      );
      
      return warehouseData?.remaining_stock || 0;
    },
    
    getStockBadgeClass(stock) {
      if (stock === 0) return 'badge-secondary';
      if (stock < 10) return 'badge-warning';
      if (stock < 5) return 'badge-danger';
      return 'badge-success';
    },

    trim_content(content, row_item = null) {
      if (typeof content == "string") {
        if (row_item == "created_at" || row_item == "updated_at") {
          return new Date(content).toLocaleTimeString();
        }

        return content.length > 20 ? content.substring(0, 20) + "..." : content;
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

.badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: bold;
  color: white;
}

.badge-primary {
  background-color: #007bff;
}

.badge-success {
  background-color: #28a745;
}

.badge-warning {
  background-color: #ffc107;
  color: #212529;
}

.badge-danger {
  background-color: #dc3545;
}

.badge-secondary {
  background-color: #6c757d;
}
</style>

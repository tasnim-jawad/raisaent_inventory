<template>
    <tr>
        <th class="w-10 text-center">
            <span class="icon"></span>
        </th>
        <th class="w-10 text-center">
            <select-all />
        </th>
        <template v-for="(item, index) in dynamicTableHeaders" :key="index">
            <th :class="index == 0 ? 'w-10' : ''"> {{ item }} </th>
        </template>
    </tr>
</template>

<script>
import setup from '../../setup';
import SelectAll from './select_data/SelectAll.vue';
import { mapWritableState, mapActions } from 'pinia';
import { store as data_store } from '../../store';

export default {
    data: () => ({
        setup,
    }),
    components: {
        SelectAll,
    },
    methods: {
        // Removed get_warehouses as it's now handled in parent component
    },
    computed: {
        ...mapWritableState(data_store, [
            'warehouses',
            'is_loading',
        ]),
        dynamicTableHeaders() {
            const baseHeaders = [
                "id",
                "title",   
                "suppliyer",
                "product category",
                "product sub category",
                "total stock",
            ];
            
            // Add warehouse columns - ensure warehouses is loaded and is an array
            console.log('WAREHOUSES from head', this.warehouses);
            
            const warehouseHeaders = (this.warehouses && Array.isArray(this.warehouses))
                ? this.warehouses.map(warehouse => `${warehouse.name || 'Warehouse'} Stock`)
                : [];
            console.log('WAREHOUSE HEADERS', warehouseHeaders);
            
            const endHeaders = [
                "status",
                "created_at", 
                "image"
            ];
            
            return [...baseHeaders, ...warehouseHeaders, ...endHeaders];
        }
    }
}
</script>

<style scoped>
.icon {
    cursor: pointer;
    position: relative;
    width: 20px;
    height: 10px;
}

.icon::after {
    content: "\f085";
    font-family: 'FontAwesome';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
}
</style>

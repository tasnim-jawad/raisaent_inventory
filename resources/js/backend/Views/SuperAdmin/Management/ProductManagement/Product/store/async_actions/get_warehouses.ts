import { mapWritableState } from "pinia";
import { store } from "..";
import setup from "../../setup";
import axios from "axios";

export default async function () {
    let state = mapWritableState(store, [
        'warehouses',
    ]);

    let url = `${setup.api_host}/${setup.api_version}/ware-houses`;

    try {
        const response = await axios.get(url, {
            params: {
                get_all: 1,
                limit: 9999
            }
        });

        if (response.data) {
            state.warehouses.set(response.data?.data || []);
        }
        console.log('WAREHOUSES LOADED:', state.warehouses.get());

        return response;
    } catch (error: any) {
        console.error('Error loading warehouses:', error);
        (window as any).s_alert('Error loading warehouses', 'error');
        return error.response;
    }
}
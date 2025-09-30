<template lang="">
    <router-link
        :to="{
            name: `Details${setup.route_prefix}`,
            params: { id: item.slug }
        }"
        class="border-secondary">
        <i class="fa fa-history text-secondary"></i>
        Log
    </router-link>
</template>
<script>
import setup from '../../../setup';

export default {
    props: {
        item: {
            type: Object,
            default: {
                slug: 1,
            },
        }
    },
    data: () => ({
        setup,
    })
}
</script>
<style lang="">

</style>

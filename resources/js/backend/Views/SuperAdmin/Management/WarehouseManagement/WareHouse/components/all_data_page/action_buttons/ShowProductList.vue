<template lang="">
    <router-link
        :to="{
            name: `ProductList${setup.route_prefix}`,
            params: { id: item.slug }
        }"
        class="border-secondary">
        <i class="fa fa-list text-secondary"></i>
        Show Product List
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

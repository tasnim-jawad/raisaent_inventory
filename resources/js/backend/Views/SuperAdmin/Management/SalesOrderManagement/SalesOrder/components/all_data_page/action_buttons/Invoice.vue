<template lang="">
  <router-link
    :to="{
      name: `Invoice${setup.route_prefix}`,
      params: { id: item.slug },
    }"
    class="border-secondary"
  >
    <i class="fa fa-file text-secondary"></i>
    Invoice
  </router-link>
</template>

<script>
import setup from "../../../setup";

export default {
  props: {
    item: {
      type: Object,
      default: {
        slug: 1,
      },
    },
  },
  data: () => ({
    setup,
  }),
};
</script>
<style lang=""></style>

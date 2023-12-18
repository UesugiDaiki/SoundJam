<template>
  <v-app>
      <nav-drawer />
      <page-title title="製品詳細" />
      <v-main>
        <product-detail/>
        <!-- <post-review /> -->
      </v-main>
  </v-app>
</template>

<script setup>
import PageTitle from '@/components/PageTitle.vue'
import NavDrawer from '@/components/NavDrawer.vue'
import ProductDetail from '@/components/ProductDetail.vue'
// import PostReview from '@/components/PostReview.vue'
</script>


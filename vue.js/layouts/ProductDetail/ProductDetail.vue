<template>
  <v-app>
      <nav-drawer />
      <page-title />
      <v-main>
        <product-detail />
      </v-main>
  </v-app>
</template>

<script setup>
import PageTitle from '@/components/PageTitle.vue'
import NavDrawer from '@/components/NavDrawer.vue'
import ProductDetail from '@/components/ProductDetail.vue'
</script>


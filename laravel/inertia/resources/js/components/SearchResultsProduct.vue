<template>
    <Product v-for="product in products" :product="product" />
</template>

<script setup>
import Product from '@/components/Product.vue'
</script>

<script>
export default {
    props: {
        products: Object,
    }
}
</script>

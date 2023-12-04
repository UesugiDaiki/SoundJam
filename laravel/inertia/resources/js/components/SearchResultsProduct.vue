<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 検索に引っかかった製品 -->
        <!-- forで表示 -->
        <!-- <Product :product="products[0]" />
            <Product :product="products[1]" />
            <Product :product="products[1]" />
            <Product :product="products[1]" />
            <Product :product="products[0]" /> -->
            <!-- </v-skeleton-loader> -->
            <Product v-for="product in products" :product="product" />
</template>

<script setup>

import Product from '@/components/Product.vue'
</script>

<script>
export default {
    // data: () => ({
    //     // 製品データ
    //     products:[
    //         {
    //             ID:1,
    //             name:"YAMAHA REVSTAR420",
    //             img:"assets/AC-3.jpg",
    //             temp_regist:false,
    //         },
    //         {
    //             ID:2,
    //             name:"YAMAHA REVSTAR4200000000000000000000000000000000000",
    //             img:"assets/AC-3.jpg",
    //             temp_regist:true,
    //         },
    //     ],
    // }),
    props: {
        products: Object,
    }
}
</script>

<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 検索に引っかかった製品 -->
        <!-- forで表示 -->
        <Product :product="products[0]" />
        <Product :product="products[1]" />

        <!-- 投稿はレビュー、自由投稿ごちゃ混ぜに検索に引っかかった順に表示 -->
        <!-- forで表示 -->
        <PostFree :post="posts[1]" />
        <PostReview :post="posts[0]" />
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import Product from '@/components/Product.vue'
import PostFree from '@/components/PostFree.vue'
import PostReview from '@/components/PostReview.vue'
</script>

<script>
export default {
    data: () => ({
        // 製品データ
        products:[
            {
                ID:1,
                name:"YAMAHA REVSTAR420",
                img:"src/assets/AC-3.jpg",
                temp_regist:false,
            },
            {
                ID:2,
                name:"YAMAHA REVSTAR420",
                img:"src/assets/AC-3.jpg",
                temp_regist:true,
            },
        ],
        // 投稿データ
        posts: [
            {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
                img: "src/assets/ms50g.png",
                music1: "src/assets/maou_bgm_piano40.mp3",
                music2: "src/assets/maou_bgm_fantasy15.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    { text: 'YAMAHA REVSTAR420' },
                    { text: 'CANARE シールド' },
                    { text: 'BOSS MS-50g' },
                    { text: 'CANARE シールド' },
                    { text: 'PRESONUS Studio 24c' },
                ],
            },
            {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "src/assets/AC-3.jpg",
                music: "src/assets/maou_bgm_acoustic54.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    { text: 'YAMAHA REVSTAR420' },
                    { text: 'CANARE シールド' },
                    { text: 'BOSS AC-3' },
                    { text: 'BOSS Equalizer GE-7' },
                    { text: 'CANARE シールド' },
                    { text: 'PRESONUS Studio 24c' },
                ],
            },
        ]
    })
}
</script>
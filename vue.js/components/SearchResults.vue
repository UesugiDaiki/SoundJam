<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
    <!-- 検索に引っかかった製品 -->
    <!-- forで表示 -->
    <Product v-for="product in products" :product="product" />
    <!-- 投稿はレビュー、自由投稿ごちゃ混ぜに検索に引っかかった順に表示 -->
    <!-- forで表示 -->
    <post v-for="post in posts" :post="post" />
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import Product from '@/components/Product.vue'
import Post from '@/components/Post.vue'
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
                    'YAMAHA REVSTAR420',
                    'CANARE シールド',
                    'BOSS MS-50g',
                    'CANARE シールド',
                    'PRESONUS Studio 24c',
                ],
                type: true,
            },
            {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "src/assets/AC-3.jpg",
                music: "src/assets/maou_bgm_acoustic54.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    'YAMAHA REVSTAR420',
                    'CANARE シールド',
                    'BOSS AC-3',
                    'BOSS Equalizer GE-7',
                    'CANARE シールド',
                    'PRESONUS Studio 24c',
                ],
                type: false,
            },
        ]
    })
}
</script>
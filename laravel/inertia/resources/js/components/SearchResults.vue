<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 検索に引っかかった製品 -->
        <!-- forで表示 -->
        <!-- <Product :product="products[0]" />
        <Product :product="products[1]" /> -->

        <!-- 投稿はレビュー、自由投稿ごちゃ混ぜに検索に引っかかった順に表示 -->
        <!-- forで表示 -->
        <post v-for="post in posts" :post="post"/>
        <!-- <post-review v-if="post.POST_TYPE === 1" :post="post"/>
        <post-free v-else :post="post"/> -->
        <!-- <PostReview :post="posts[0]" />
        <PostFree :post="posts[1]" /> -->
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import Post from '@/components/Post.vue'
import Product from '@/components/Product.vue'
import PostFree from '@/components/PostFree.vue'
import PostReview from '@/components/PostReview.vue'
</script>

<script>
export default {
    // //ページ読み込み時
    // async created() {
    //     await this.getPosts();
    //     // 1分ごとにデータベースから投稿データを取得する
    //     this.reactiveGetPosts();
    //     console.log(this.IntervalId);
    // },
    // //ページ読み込み後
    // mounted() {
    // },
    // //ページ離脱時に実行
    // unmounted() {
    //     console.log('setIntervalのID:' + this.IntervalId);
    //     //リアルタイム更新停止
    //     clearInterval(this.IntervalId);
    //     console.log('setIntervalを停止しました')
    // },
    // methods: {
    //     // 投稿データ取得
    //     async getPosts() {
    //         const res = await axios.get("/api/getPosts");
    //         this.posts = res.data;
    //         console.log(this.posts);
    //     },
    //     // 投稿リアルタイム更新
    //     async reactiveGetPosts() {
    //         this.IntervalId = await setInterval(() => {
    //             this.getPosts();
    //             console.log('更新されました');
    //         }, 10000);
    //     },
    // },
    props: {
        posts: Object,
    },
    data: () => ({
        // posts: [],
        // // 製品データ
        // products:[
        //     {
        //         ID:1,
        //         name:"YAMAHA REVSTAR420",
        //         img:"assets/AC-3.jpg",
        //         temp_regist:false,
        //     },
        //     {
        //         ID:2,
        //         name:"YAMAHA REVSTAR420",
        //         img:"assets/AC-3.jpg",
        //         temp_regist:true,
        //     },
        // ],
        // 投稿データ
        // posts: [
        //     {
        //         name: "雅弥",
        //         myImg: "assets/masaya.png",
        //         title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
        //         img: "assets/ms50g.png",
        //         music1: "assets/maou_bgm_piano40.mp3",
        //         music2: "assets/maou_bgm_fantasy15.mp3",
        //         recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
        //         items: [
        //             { text: 'YAMAHA REVSTAR420' },
        //             { text: 'CANARE シールド' },
        //             { text: 'BOSS MS-50g' },
        //             { text: 'CANARE シールド' },
        //             { text: 'PRESONUS Studio 24c' },
        //         ],
        //     },
        //     {
        //         name: "雅弥",
        //         myImg: "assets/masaya.png",
        //         title: "エレキギターをアコギの音に！！！",
        //         img: "assets/AC-3.jpg",
        //         music: "assets/maou_bgm_acoustic54.mp3",
        //         recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
        //         items: [
        //             { text: 'YAMAHA REVSTAR420' },
        //             { text: 'CANARE シールド' },
        //             { text: 'BOSS AC-3' },
        //             { text: 'BOSS Equalizer GE-7' },
        //             { text: 'CANARE シールド' },
        //             { text: 'PRESONUS Studio 24c' },
        //         ],
        //     },
        // ]
    })
}
</script>

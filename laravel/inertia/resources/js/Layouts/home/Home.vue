<template>
    <v-app>
        
        <nav-drawer />
        <v-main class="mt-n5 leftLength">
            <!-- "丸" -->
            <div v-if="reloadCircular" class="text-center my-10">
                <v-progress-circular :indeterminate="reloadCircular"></v-progress-circular>
            </div>
            <post v-for="post in posts" :post="post"/>
            <v-card v-if="posts.length === 0 && !reloadCircular" elevation="0" class="my-10 pa-4">
                <v-card-text class="text-center text-h5 pa-0">投稿がありません</v-card-text>
                <v-card-text class="text-center text-caption pa-0">まずは気になるキーワードを検索してみましょう</v-card-text>
            </v-card>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/Components/NavDrawer.vue'
import Post from '@/Components/Post.vue'
</script>

<script>
export default {
    //ページ読み込み時
    async created() {
        this.reloadCircular = true;
        await this.getPosts();
        this.reloadCircular = false;
        // 1分ごとにデータベースから投稿データを取得する
        this.reactiveGetPosts();
    },
    //ページ離脱時に実行
    unmounted() {
        //リアルタイム更新停止
        clearInterval(this.IntervalId);
    },
    methods: {
        // 投稿データ取得
        async getPosts() {
            const res = await axios.get("/api/getPosts");
            this.posts = res.data;
        },
        // 投稿リアルタイム更新
        async reactiveGetPosts() {
            this.IntervalId = await setInterval(() => {
                this.getPosts();
            }, 10000);
        },
    },
    data: () => ({
        posts: [],
        IntervalId: null,
        reloadCircular: false,
    })
}
</script>

<style scoped>
.leftLength{
    /* 画面が850px以上の場合適応 */
    --v-layout-left: 18% !important;
}
    
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .leftLength{
            --v-layout-left: 24% !important;
        }
    }
</style>

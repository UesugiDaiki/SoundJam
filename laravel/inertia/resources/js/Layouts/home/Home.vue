<template>
    <v-app>
        <nav-drawer />

        <v-main class="mt-n5">
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
import NavDrawer from '@/components/NavDrawer.vue'
import Post from '@/components/Post.vue'
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
        console.log(this.IntervalId);
    },
    //ページ離脱時に実行
    unmounted() {
        console.log('setIntervalのID:' + this.IntervalId);
        //リアルタイム更新停止
        clearInterval(this.IntervalId);
        console.log('setIntervalを停止しました')
    },
    methods: {
        // 投稿データ取得
        async getPosts() {
            const res = await axios.get("/api/getPosts");
            // const res = await axios.get("/api/getUserPostData");
            this.posts = res.data;
            console.log(this.posts);
        },
        // 投稿リアルタイム更新
        async reactiveGetPosts() {
            this.IntervalId = await setInterval(() => {
                this.getPosts();
                console.log('更新されました');
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

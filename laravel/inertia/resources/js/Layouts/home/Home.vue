<template>
    <v-app>
        <nav-drawer />

        <v-main class="mt-n5">
            <post v-for="post in posts" :post="post"/>
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
        await this.getPosts();
        // 1分ごとにデータベースから投稿データを取得する
        this.reactiveGetPosts();
        console.log(this.IntervalId);
    },
    //ページ読み込み後
    mounted() {
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
    })
}
</script>

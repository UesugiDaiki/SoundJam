<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 投稿をレビュー、自由投稿ごちゃ混ぜにいいねが多い順に表示 -->
        <!-- forで表示 -->
        <post v-for="post in posts" :post="post"/>
        <!-- <PostFree :post="posts[1]" />
        <PostReview :post="posts[0]" />
        <PostReview :post="posts[0]" />
        <PostReview :post="posts[0]" /> -->
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import Post from '@/components/Post.vue'
import PostFree from '@/components/PostFree.vue'
import PostReview from '@/components/PostReview.vue'
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
    })
}
</script>

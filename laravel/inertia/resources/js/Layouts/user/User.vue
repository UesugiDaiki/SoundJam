<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <!-- ページタイトル -->
            <page-title :title="user.USER_NAME" />
            <!-- プロフィール -->
            <profile :user="user" />
            <!-- ユーザの投稿 -->
            <post v-for="post in posts" :post="post"/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/Components/NavDrawer.vue'
import PageTitle from '@/Components/PageTitle.vue'
import Profile from '@/Components/Profile.vue'
import Post from '@/Components/Post.vue'
</script>

<script>
export default {
    async created() {
        //　ユーザの投稿関連データ取得
        await this.getUserPostData();
        //　ユーザー情報取得
        await this.getUser();
    },
    methods: {
        // //ユーザー情報取得
        async getUser() {
            const res = await axios.post('/api/getUser', {userId: this.$route.params.userId});
            // 投稿データ取得
            this.user = res.data;
        },

        // ユーザの投稿関連データ取得
        async getUserPostData() {
            const res = await axios.post('/api/getUserPostData', {userId: this.$route.params.userId});
            // 投稿データ取得
            this.posts = res.data;
        },
    },
    data: () => ({
        posts: [],
        user: [],
    }),

}
</script>

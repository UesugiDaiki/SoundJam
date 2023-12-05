<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title :title="user.USER_NAME" />
            <profile :user="user" />
            <!-- 応急処置 -->
            <post v-for="post in posts" :post="post"/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import PageTitle from '@/components/PageTitle.vue'
import Profile from '@/components/Profile.vue'
import Post from '@/components/Post.vue'
</script>

<script>
export default {
    async created() {
        await this.getUserPostData();
        //応急処置
        await this.getUser();
    },
    methods: {
        // //ユーザー情報取得
        async getUser() {
            const res = await axios.post('/api/getUser', {userId: this.$route.params.userId});
            // const res = await axios.post('/api/getUser', {userId: 3});
            console.log(res.data);
            // 投稿データ取得
            this.user = res.data;
        },

        //投稿
        async getUserPostData() {
            const res = await axios.post('/api/getUserPostData', {userId: this.$route.params.userId});
            // const res = await axios.post('/api/getUserPostData', {userId: 3});
            console.log(res.data);
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

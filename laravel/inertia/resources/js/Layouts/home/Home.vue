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
    async created() {
        await this.getPosts();
    },
    methods: {
        async getPosts() {
            const res = await axios.get("/api/getPosts");
            this.posts = res.data;
        },
    },
    data: () => ({
        posts: [],
    })
}
</script>
<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 投稿をレビュー、自由投稿ごちゃ混ぜに投稿が新しい順に表示 -->
        <!-- forで表示 -->
        <post v-for="post in posts" :post="post"/>
        <!-- <PostReview :post="posts[0]" />
        <PostReview :post="posts[0]" />
        <PostFree :post="posts[1]" />
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
    props: {
        posts: [],
    }
}
</script>

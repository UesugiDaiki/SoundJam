<template>
    <post v-for="post in posts" :post="post"/>
</template>

<script setup>
import Post from '@/Components/Post.vue'
import PostFree from '@/Components/PostFree.vue'
import PostReview from '@/Components/PostReview.vue'
</script>

<script>
export default {
    props: {
        posts: Object,
    }
}
</script>

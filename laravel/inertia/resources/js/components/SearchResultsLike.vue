<template>
    <post v-for="post in posts" :post="post"/>
</template>

<script setup>
import Post from '@/components/Post.vue'
import PostFree from '@/components/PostFree.vue'
import PostReview from '@/components/PostReview.vue'
</script>

<script>
export default {
    props: {
        posts: Object,
    }
}
</script>

<template>
    <post-review v-if="post.POST_TYPE === 1" :post="post"/>
    <post-free v-else :post="post"/>
</template>

<script setup>
import PostReview from './PostReview.vue';
import PostFree from './PostFree.vue';
</script>

<script>
export default {
    props: {
        post: Object,
    }
}
</script>

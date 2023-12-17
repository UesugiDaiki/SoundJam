<template>
    <an-user v-for="user in users" :user="user" />
    <post v-for="post in posts" :post="post"/>
</template>

<script setup>
import AnUser from '@/components/AnUser.vue'
import Post from '@/components/Post.vue'

</script>

<script>
export default {
    props: {
        posts: Object,
        users: Object,
    },
}
</script>

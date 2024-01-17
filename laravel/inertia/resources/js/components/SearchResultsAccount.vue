<template>
    <an-user v-for="user in users" :user="user" />
</template>

<script setup>
import AnUser from '@/Components/AnUser.vue'
</script>

<script>
export default {
    props: {
        users: Object,
    }
}
</script>

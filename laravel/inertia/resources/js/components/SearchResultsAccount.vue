<template>
    <an-user v-for="user in users" :user="user" />
</template>

<script setup>
import AnUser from '@/components/AnUser.vue'
</script>

<script>
export default {
    data: () => ({
    }),
    props: {
        users: Object,
    }
}
</script>

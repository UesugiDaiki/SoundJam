<template>
    <v-app>
        <nav-drawer />
        <v-main>
            <post-detail />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import PostDetail from '@/components/PostDetail.vue'
</script>

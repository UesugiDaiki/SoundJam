<template>
    <v-app>
        <nav-drawer />
        <page-title title="投稿詳細" />
        <v-main>
            <post-detail />
        </v-main>
    </v-app>
</template>

<script setup>
import PageTitle from '@/Components/PageTitle.vue'
import NavDrawer from '@/Components/NavDrawer.vue'
import PostDetail from '@/Components/PostDetail.vue'
</script>

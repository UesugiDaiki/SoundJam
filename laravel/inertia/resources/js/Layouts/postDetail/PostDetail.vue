<template>
    <v-app>
        <nav-drawer />
        <!-- <page-title title="投稿詳細" /> -->
        <v-main>
            <post-detail />
        </v-main>
    </v-app>
</template>

<script setup>
import PageTitle from '@/components/PageTitle.vue'
import NavDrawer from '@/components/NavDrawer.vue'
import PostDetail from '@/components/PostDetail.vue'
</script>

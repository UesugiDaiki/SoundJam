<template>
    <v-app>
        <nav-drawer />
        <page-title title="投稿詳細" />
        <v-main class="leftLength">
            <post-detail />
        </v-main>
    </v-app>
</template>

<script setup>
import PageTitle from '@/Components/PageTitle.vue'
import NavDrawer from '@/Components/NavDrawer.vue'
import PostDetail from '@/Components/PostDetail.vue'
</script>

<style scoped>
.leftLength{
    /* 画面が850px以上の場合適応 */
    --v-layout-left: 18% !important;
}
    
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .leftLength{
            --v-layout-left: 24% !important;
        }
    }
</style>
<template>
    <v-app>
        <nav-drawer />
        
        <v-main style="--v-layout-left: 44%; --v-layout-top: 3%;">
            <page-title title="設定"/>
            <v-navigation-drawer  style="left: 24%; top: 13%; width: 20%; padding: 0;" permanent>
                <v-list>
                    <v-list-item to="/settings/reset_password" title="パスワード再設定" value="2"></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <router-view />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/Components/NavDrawer.vue'
import PageTitle from '@/Components/PageTitle.vue';
</script>
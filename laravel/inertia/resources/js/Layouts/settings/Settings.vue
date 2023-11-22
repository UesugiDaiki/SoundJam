<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <v-navigation-drawer permanent>
                <v-list>
                    <v-list-item-title> <span class="mx-4 mt-5 text-h5">設定</span> </v-list-item-title>
                    <v-divider></v-divider>
                    <v-list-item to="/settings/notice_setting" title="通知設定" value="1"></v-list-item>
                    <v-list-item to="/settings/reset_password" title="パスワード再設定" value="2"></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <router-view />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
</script>
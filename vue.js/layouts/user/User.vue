<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title title="ユーザー名"/>

            <profile />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import Profile from '@/components/Profile.vue';
import PageTitle from '@/components/PageTitle.vue';
</script>

<script>
export default {
    data: () =>
}
</script>
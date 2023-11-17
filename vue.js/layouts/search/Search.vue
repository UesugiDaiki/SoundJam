<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <search-bar />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import SearchBar from '@/components/SearchBar.vue'
</script>
<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <SearchBar class="my-3" />

            <v-card max-width="555px" class="mx-auto" elevation="0" hide-details>
                <v-tabs bg-color="" slider-color="teal-lighten-3">
                    <v-tab :key="1" :value="1" class="px-8"> すべて </v-tab>
                    <v-tab :key="2" :value="2" class="px-8"> いいね</v-tab>
                    <v-tab :key="3" :value="3" class="px-8"> 最新</v-tab>
                    <v-tab :key="4" :value="4" class="px-8"> 製品 </v-tab>
                    <v-tab :key="5" :value="5" class="px-8"> アカウント </v-tab>
                </v-tabs>
            </v-card>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import SearchBar from '@/components/SearchBar.vue'
</script>
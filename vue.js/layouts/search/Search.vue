<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <v-app-bar elevation="0">
                <SearchBar class="my-3" />
            </v-app-bar>

            <v-app-bar elevation="0">
                <v-card max-width="556" class="mx-auto" elevation="0" hide-details>
                    <v-tabs bg-color="" slider-color="teal-lighten-3" v-model="searchTab">
                        <v-tab :key="1" :value="1" class="px-8">すべて </v-tab>
                        <v-tab :key="2" :value="2" class="px-8">いいね</v-tab>
                        <v-tab :key="3" :value="3" class="px-8">最新</v-tab>
                        <v-tab :key="4" :value="4" class="px-8">製品 </v-tab>
                        <v-tab :key="5" :value="5" class="px-8">アカウント </v-tab>
                    </v-tabs>
                </v-card>
            </v-app-bar>

            <!-- タブで表示変える部分 -->
            <v-window v-model="searchTab">

                <!-- 検索結果(すべて) -->
                <v-window-item :value="1"> 
                    <SearchResults  />
                </v-window-item>

                <!-- 検索結果(いいね順) -->
                <v-window-item :value="2"> 
                    <search-results-like  />
                </v-window-item>

                <!-- 検索結果(新着順) -->
                <v-window-item :value="3"> 
                    <search-results-new  />
                </v-window-item>

                <!-- 検索結果(製品) -->
                <v-window-item :value="4"> 
                    <search-results-product />
                </v-window-item>

                <!-- 検索結果(アカウント) -->
                <v-window-item :value="5"> 
                    
                </v-window-item>
            </v-window>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import SearchBar from '@/components/SearchBar.vue'
import SearchResults from '@/components/SearchResults.vue'
import SearchResultsLike from '@/components/SearchResultsLike.vue'
import SearchResultsNew from '@/components/SearchResultsNew.vue'
import SearchResultsProduct from '@/components/SearchResultsProduct.vue'
</script>

<script>
    export default {
        data: () => ({
            searchTab: 1,
        }),
    }
</script>
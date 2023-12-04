<template>
    <v-app>
        <nav-drawer />

        <v-app-bar elevation="0">
            <SearchBar class="my-3" />
        </v-app-bar>

        <v-app-bar elevation="0" >
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

        <v-main style="padding-top: 96px;">
            <!-- タブで表示変える部分 -->
            <v-window v-model="searchTab" class="py-3">

                <!-- 検索結果(すべて) -->
                <v-window-item :value="1">
                    <SearchResults :posts="post" />
                </v-window-item>

                <!-- 検索結果(いいね順) -->
                <v-window-item :value="2">
                    <search-results-like :posts="post"/>
                </v-window-item>

                <!-- 検索結果(新着順) -->
                <v-window-item :value="3">
                    <search-results-new :posts="post"/>
                </v-window-item>

                <!-- 検索結果(製品) -->
                <v-window-item :value="4">
                    <search-results-product :products="product"/>
                </v-window-item>

                <!-- 検索結果(アカウント) -->
                <v-window-item :value="5">
                    <search-results-account :users="account"/>
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
import SearchResultsAccount from '@/components/SearchResultsAccount.vue'
</script>

<script>
    export default {
        async created() {
            // 全投稿データ取得
            await this.getPosts();
            //全アカウント取得
            await this.getAccount();
            //全製品データ取得
            await this.getProduct();
            // 1分ごとにデータベースから投稿データを取得する
            await this.reactiveGetPosts();
        },
        //ページ離脱時に実行
        unmounted() {
            console.log('setIntervalのID:' + this.IntervalId);
            //リアルタイム更新停止
            clearInterval(this.IntervalId);
            console.log('setIntervalを停止しました')
        },
        methods: {
            // 投稿データ取得
            async getPosts() {
                const res = await axios.get("/api/getPosts");
                this.post = res.data;
                console.log(this.post);
            },
            //全アカウント情報を取得
            async getAccount() {
                const res = await axios.get('/api/getAccount');;
                this.account = res.data;
                console.log(this.account)
            },
            //全製品情報を取得
            async getProduct() {
                const res = await axios.get('/api/getProduct');
                this.product = res.data;
                console.log(this.product)
            },
            // 投稿リアルタイム更新
            async reactiveGetPosts() {
                this.IntervalId = await setInterval(() => {
                    this.getPosts();
                    this.getAccount();
                    this.getProduct();
                    console.log('更新されました');
                }, 10000);
            },
        },
        data: () => ({
            searchTab: 1,
            account: [],
            product: [],
            post: [],
        }),
    }
</script>

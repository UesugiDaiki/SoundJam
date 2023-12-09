<template>
    <v-app>
        <nav-drawer />

        <v-app-bar elevation="0">
            <v-responsive class="mx-auto my-3" min-width="340" max-width="460">
                <v-text-field flat rounded bg-color="black" density="compact" variant="solo" append-inner-icon="$magnify"
                    single-line hide-details @click:append-inner="search" @keypress.enter="search" v-model="searchWord"></v-text-field>
            </v-responsive>
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

        <v-main style="padding-top: 96px;">
            <div v-if="searching" class="text-center my-10">
                <v-progress-circular :indeterminate="searching"></v-progress-circular>
            </div>

            <!-- タブで表示変える部分 -->
            <v-window v-model="searchTab" class="py-3">

                <!-- 検索結果(すべて) -->
                <v-window-item :value="1">
                    <SearchResults :posts="likePosts" :users="users" :products="products" />
                </v-window-item>

                <!-- 検索結果(いいね順) -->
                <v-window-item :value="2">
                    <search-results-like :posts="likePosts" />
                </v-window-item>

                <!-- 検索結果(新着順) -->
                <v-window-item :value="3">
                    <search-results-new :posts="newestPosts" />
                </v-window-item>

                <!-- 検索結果(製品) -->
                <v-window-item :value="4">
                    <search-results-product :products="products" />
                </v-window-item>

                <!-- 検索結果(アカウント) -->
                <v-window-item :value="5">
                    <search-results-account :users="users" />
                </v-window-item>

            </v-window>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
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
        // await this.getPosts();
        //全アカウント取得
        // await this.getAccount();
        //全製品データ取得
        // await this.getProduct();
        // 1分ごとにデータベースから投稿データを取得する
        // await this.reactiveGetPosts();
    },
    //ページ離脱時に実行
    unmounted() {
        console.log('setIntervalのID:' + this.IntervalId);
        //リアルタイム更新停止
        clearInterval(this.IntervalId);
        console.log('setIntervalを停止しました')
    },
    methods: {
        // // 投稿データ取得
        // async getPosts() {
        //     const res = await axios.get("/api/getPosts");
        //     this.post = res.data;
        //     console.log(this.post);
        // },
        // //全アカウント情報を取得
        // async getAccount() {
        //     const res = await axios.get('/api/getAccount');;
        //     this.account = res.data;
        //     console.log(this.account)
        // },
        // //全製品情報を取得
        // async getProduct() {
        //     const res = await axios.get('/api/getProduct');
        //     this.product = res.data;
        //     console.log(this.product)
        // },
        // // 投稿リアルタイム更新
        // async reactiveGetPosts() {
        //     this.IntervalId = await setInterval(() => {
        //         this.getPosts();
        //         this.getAccount();
        //         this.getProduct();
        //         console.log('更新されました');
        //     }, 10000);
        // },

        // 検索
        async search() {
            this.searching = true
            let searchData = {
                searchWords: this.searchWords,
                all: this.all,
                like: this.like,
                newest: this.newest,
                product: this.product,
                user: this.user,
            }

            switch (this.searchTab) {
                // 「すべて」検索
                case 1:
                    axios.post('/api/searchAll', searchData)
                        .then(function() {

                        })
                        .catch(function() {

                        })
                    break;

                // 「いいね」検索
                case 2:
                    let _likePosts
                    await axios.post('/api/searchLike', searchData)
                        .then(function(response) {
                            console.log('成功')
                            console.log(response)
                            _likePosts = response.data
                        })
                        .catch(function() {
                            console.log('失敗')
                        })
                    
                    this.searching = false
                    for (let i = 0; i < _likePosts.length; i++) {
                        this.likePosts.push(_likePosts[i])
                    }
                    this.like++
                    break;

                // 「最新順」検索
                case 3:
                    let _newestPosts
                    await axios.post('/api/searchNewest', searchData)
                        .then(function(response) {
                            console.log('成功')
                            console.log(response)
                            _newestPosts = response.data
                        })
                        .catch(function(error) {
                            console.log('失敗')
                            console.log(error)
                        })

                    this.searching = false
                    for (let i = 0; i < _newestPosts.length; i++) {
                        this.newestPosts.push(_newestPosts[i])
                    }
                    this.newest++
                    break;

                // 「製品」検索
                case 4:
                    axios.post('/api/searchProduct', searchData)
                        .then(function() {

                        })
                        .catch(function() {

                        })
                    break;

                // 「アカウント」検索
                case 5:
                    axios.post('/api/searchUser', searchData)
                        .then(function() {

                        })
                        .catch(function() {

                        })
                    break;
            }
        }
    },
    data: () => ({
        // 検索中か
        searching: false,
        // 検索内容
        searchTab: 1,
        searchWord: '',
        // 検索回数
        all: 0,
        like: 0,
        newest: 0,
        product: 0,
        user: 0,
        // 検索結果
        users: [],
        products: [],
        likePosts: [],
        newestPosts: [],
    }),
    computed: {
        // 空白区切りで配列化
        searchWords() {
            return this.searchWord.split(/\s+/)
        }
    }
}
</script>

<template>
    <v-app>
        <nav-drawer />

        <v-app-bar elevation="0">
            <v-responsive class="mx-auto my-3" min-width="340" max-width="460">
                <v-text-field flat rounded bg-color="#dcdcdc" density="compact" variant="solo" append-inner-icon="$magnify"
                    single-line hide-details @click:append-inner="firstSearch" @keypress.enter="firstSearch" v-model="searchWord"></v-text-field>
            </v-responsive>
        </v-app-bar>

        <v-app-bar elevation="0">
            <v-card max-width="556" class="mx-auto" elevation="0" hide-details>
                <v-tabs bg-color="" slider-color="#733cff" v-model="searchTab">
                    <v-tab :key="1" :value="1" class="px-8" @click="firstSearch">すべて </v-tab>
                    <v-tab :key="3" :value="3" class="px-8" @click="firstSearch">最新</v-tab>
                    <v-tab :key="5" :value="5" class="px-8" @click="firstSearch">アカウント </v-tab>
                </v-tabs>
            </v-card>
        </v-app-bar>

        <v-main style="padding-top: 96px;">
            <!-- "丸" -->
            <div v-if="firstSearching" class="text-center my-10">
                <v-progress-circular :indeterminate="firstSearching"></v-progress-circular>
            </div>

            <!-- タブで表示変える部分 -->
            <v-window v-model="searchTab" class="py-3">

                <!-- 検索結果(すべて) -->
                <v-window-item :value="1">
                    <v-card v-if="newestPosts.length + users.length == 0 && !firstSearching" elevation="0" class="my-10 text-center text-h5">
                        検索結果は見つかりませんでした
                    </v-card>
                    <SearchResults :posts="newestPosts" :users="users" />
                </v-window-item>

                <!-- 検索結果(新着順) -->
                <v-window-item :value="3">
                    <v-card v-if="newestPosts.length == 0 && !firstSearching" elevation="0" class="my-10 text-center text-h5">
                        検索結果は見つかりませんでした
                    </v-card>
                    <search-results-new :posts="newestPosts" />
                </v-window-item>

                <!-- 検索結果(アカウント) -->
                <v-window-item :value="5">
                    <v-card v-if="users.length == 0 && !firstSearching" elevation="0" class="my-10 text-center text-h5">
                        検索結果は見つかりませんでした
                    </v-card>
                    <search-results-account :users="users" />
                </v-window-item>

            </v-window>

            <!-- "丸" -->
            <div v-if="searching" class="text-center my-10">
                <v-progress-circular :indeterminate="searching"></v-progress-circular>
            </div>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/Components/NavDrawer.vue'
import SearchResults from '@/Components/SearchResults.vue'
import SearchResultsNew from '@/Components/SearchResultsNew.vue'
import SearchResultsAccount from '@/Components/SearchResultsAccount.vue'
</script>

<script>
export default {
    created() {
        this.firstSearch()
    },
    //ページ離脱時に実行
    unmounted() {
        //リアルタイム更新停止
        clearInterval(this.IntervalId);
    },
    methods: {
        // 検索バー検索
        async firstSearch() {
            this.firstSearching = true
            this.newestPosts = [],
            this.users = [],
            this.all = 0
            this.newest = 0
            this.user = 0
            let searchData = {
                searchWords: this.searchWords,
                all: this.all,
                newest: this.newest,
                user: this.user,
            }

            switch (this.searchTab) {
                // 「すべて」検索
                case 1:
                    let __newestPosts
                    let __users
                    await axios.post('/api/searchNewest', searchData)
                        .then(function(response) {
                            __newestPosts = response.data
                        })
                    await axios.post('/api/searchUser', searchData)
                        .then(function(response) {
                            __users = response.data
                        })
                    this.firstSearching = false
                    this.newestPosts = __newestPosts
                    this.users = __users
                    break;

                // 「最新順」検索
                case 3:
                    let _newestPosts
                    await axios.post('/api/searchNewest', searchData)
                        .then(function(response) {
                            _newestPosts = response.data
                        })

                    this.firstSearching = false
                    this.newestPosts = _newestPosts
                    this.newest++
                    break;

                // 「アカウント」検索
                case 5:
                    let _users
                    await axios.post('/api/searchUser', searchData)
                        .then(function(response) {
                            _users = response.data
                        })
                        this.firstSearching = false
                        this.users = _users
                        this.user++
                    break;
            }
        },

        // 画面スクロール（もしくは画面下部ボタン）検索
        async search() {
            this.searching = true
            let searchData = {
                searchWords: this.searchWords,
                all: this.all,
                newest: this.newest,
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

                // 「最新順」検索
                case 3:
                    let _newestPosts
                    await axios.post('/api/searchNewest', searchData)
                        .then(function(response) {
                            _newestPosts = response.data
                        })

                    this.searching = false
                    for (let i = 0; i < _newestPosts.length; i++) {
                        this.newestPosts.push(_newestPosts[i])
                    }
                    this.newest++
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
        firstSearching: false,
        searching: false,
        // 検索内容
        searchTab: 1,
        searchWord: '',
        // 検索回数
        all: 0,
        newest: 0,
        user: 0,
        // 検索結果
        users: [],
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

<template>
    <v-row align="center" justify="center">
        <v-col cols="auto" class="soto">
            <v-card class="mx-auto" width="570px" max-width="570" min-width="200" rounded="0" elevation="0" :ripple="false">
                <TitleDetail :post="post" />
                <v-card-subtitle class="day">
                    {{ post.DATES }}
                </v-card-subtitle>

                <v-card-title>
                    {{ post.TITLE }}
                    <div v-if="post.POST_TYPE === 1" class="Item-Content-Flg4"></div>
                </v-card-title>
                <div class="aaa">
                    <v-img max-width="250" min-width="250" max-height="190" min-height="190"
                        :src="'../../storage/post/' + post.id + '/' + post.IMAGES">
                    </v-img>
                    <div class="audio">
                        <audio controlslist="nodownload" class="audio-position" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                    </div>
                </div>

                <v-card-title>
                    概要
                </v-card-title>
                <v-card-text>
                    {{ post.OVERVIEW }}
                </v-card-text>
                <v-divider></v-divider>
                <v-expand-transition class="mb-5">
                    <div v-show="show">
                        <v-row no-gutters>
                            <div class="add1">
                                <h2>
                                    使用機材
                                </h2>
                                <v-list v-for="(item, i) in post.ITEMS" :key="i" :value="item" color="primary">
                                    <v-list-item-title :padding="0">■{{ item }}</v-list-item-title>
                                </v-list>
                            </div>
                            <v-divider vertical class="mx-4 border-opacity-25" inset></v-divider>
                            <div class="add2">
                                <h2>
                                    録音方法
                                </h2>
                                {{ post.RECORDING_METHOD }}
                            </div>
                        </v-row>
                    </div>
                </v-expand-transition>
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup>
import TitleDetail from './TitleDetail.vue'
</script>

<script>
export default {
    //ページ読み込み時発動
    async created() {
        //　storeに保存している投稿データを取得
        this.post = this.$store.state.postData;
        // URLで直接画面遷移しているか
        if (this.post.id === undefined) {
            // している場合
            let postId = Number(this.$route.path.replace(/[^0-9]/g, ''));
            let _post
            await axios.post("/api/getPostDetail", {postId: postId})
                .then(function(response){
                    _post = response.data
                })
            this.post = _post
        }

        // 画面表示位置を一番上に移動
        window.scrollTo({
            top: 0,
        })
    },
    data: () => ({
        //投稿データを保存するデータ
        post: {},
        show: true,
        reveal: false,
    }),
}
</script>

<style>
.like {
    padding: 0;
    margin-right: 50px;
}

.aaa {
    display: flex;
    gap: 6px;
    padding-left: 6px;
    margin-bottom: 20px;
}

.center {
    float: left;
}

.v-card--reveal {
    bottom: 0;
    opacity: 1 !important;
    position: absolute;
    width: 100%;
}

.audio {
    width: 300px;
}

.audio-position {
    margin-top: 20px;
}

.audio-position-free {
    margin-top: 80px;
}

.add1 {
    width: 250px;
    margin-left: 20px;
    margin-top: 20px;
}

.add2 {
    width: 250px;
    margin-top: 20px;
}

.text-length {
    height: 120px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    /* 任意の行数を指定 */
}

.soto {
    padding: 0;
}

.Item-Content-Flg4 {
    /*三角形右上*/
    position: absolute;
    top: 0;
    right: 0;
    border-top: 40px solid #5bc8ac;
    border-left: 40px solid transparent;
}

.day {
    padding-top: 10px;
    text-align: right;
}
</style>

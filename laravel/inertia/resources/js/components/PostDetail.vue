<template>
    <v-row  align="center" justify="center">
        <v-col cols="auto" class="soto">
            <v-card class="mx-auto"  max-width="570"  rounded="0" elevation="0" :ripple="false">
                <TitleDetail :post="post" />
                <v-card-subtitle class="day">
                    {{ post.DATES }}
                </v-card-subtitle>

                <v-card-title>
                    {{ post.TITLE }}

                    <div v-if="post.IS_PROMOTION === 2">
                        <div v-if="windowWidth > 850" class="Promo">
                        </div>
                        <div class="Promo-Text">
                            PR
                        </div>
                        <div v-if="windowWidth <= 850" style="right: 50%;" class="Promo">
                        </div>
                        <div class="Promo-Text">
                            PR
                        </div>
                    </div>
                    <div v-else-if="post.POST_TYPE === 1" class="Item-Content-Flg4"></div>
                    
                </v-card-title>
                <div class="aaa">
                    <v-img class="postImg"
                        :src="'../../storage/post/' + post.id + '/' + post.IMAGES">
                    </v-img>
                    <div class="audio">
                        <!-- 音声1個ver -->
                        <div v-if="post.AUDIO2 === null">
                            <audio controlslist="nodownload" class="audio-position" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                            
                            
                        </div>
                        <!-- 音声2個ver -->
                        <div v-else>
                            <!-- 画面幅850pxより大きい場合 -->
                            <audio  v-if="windowWidth > 850" controlslist="nodownload" class="audio-position-review mt-4" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                            <audio  v-if="windowWidth > 850" controlslist="nodownload" class="audio-position-review mt-3" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO2"></audio>
                            <!-- 画面幅850px以下の場合 -->
                            <audio v-if="windowWidth <= 850" controlslist="nodownload" class="audio-position-review" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                            <audio v-if="windowWidth <= 850" controlslist="nodownload" class="audio-position-review" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO2"></audio>
                        </div>
                    </div>
                </div>

                <v-card-title>
                    <h3>
                        概要
                    </h3>
                </v-card-title>
                <v-card-text>
                    {{ post.OVERVIEW }}
                </v-card-text>
                <v-divider></v-divider>
                <v-expand-transition class="mb-5">
                    <div v-show="show">
                        <!-- 画面幅850pxより大きい場合 -->
                        <v-row  no-gutters v-if="windowWidth > 850">
                                <div class="add1" >
                                    <h2>
                                        使用機材
                                    </h2>
                                    <v-list v-for="item in post.ITEMS" :key="item" :value="item" color="primary" class="py-0"  >
                                        <v-list-item class="py-1" width="250px" :padding="0"><div>■{{ item }}</div></v-list-item>
                                    </v-list>
                                </div>
                                <v-divider vertical class="mx-4  border-opacity-25" inset></v-divider>
                                <div class="add2">
                                    <h2 class="py-1">
                                        録音方法
                                    </h2>
                                    {{ post.RECORDING_METHOD }}
                                </div>
                        </v-row>
                            <!-- 画面幅850px以下の場合 -->
                        <div v-if="windowWidth <= 850">
                            <div  style="display: block;" class="mx-auto" @click="notDo($event)">
                                <v-card-title>
                                <h3 >
                                    使用機材
                                </h3>
                                </v-card-title>
                                <v-list v-for="item in post.ITEMS" :key="item" :value="item" color="primary" class="py-0"  >
                                    <v-list-item class="py-1" width="250px" :padding="0"><div>■{{ item }}</div></v-list-item>
                                </v-list>
                            </div>
                            <v-divider></v-divider>
                            <div style="display: block;" class="mx-auto my-3 pb-2 " >
                                <v-card-title>
                                <h3 >
                                    録音方法
                                </h3>
                                </v-card-title>
                                <div class="mx-4">{{ post.RECORDING_METHOD }} </div>
                            </div>
                        </div>
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
        if (this.post.id !== Number(this.$route.path.replace(/[^0-9]/g, ''))) {
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
        windowWidth: window.innerWidth,
    }),
    mounted () {
        // 画面幅が切り替わる毎に関数呼び出し
        window.addEventListener('resize', this.resizeWindow)
    },
    methods: {
        // 現在の画面幅を変数の中に入れる
        resizeWindow(){
            this.windowWidth = window.innerWidth
        },
    }
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
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .aaa{
            display: block;
        }
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

.postImg{
    width: 250px;
    height: 200px;
}
        /* 画面が850px以下の場合適応 */
        @media screen and (max-width: 850px) {
            .postImg{
                /* left: 13%; */
                display: block;
                margin-left: auto;
                margin-right: auto 
            }
        }

.audio {
    width: 300px;
    margin-bottom: auto;
}
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .audio{
            width: 300px;
            height: 100px;
            display: block;
            margin-top: 3px;
            margin-left: auto;
            margin-right: auto 
            
        }
    }


.audio-position-free {
    margin-top: 3px;
    width: 300px;
}
/* 画面が850px以下の場合適応 */
@media screen and (max-width: 850px) {
    .audio-position-free{
        width: 100%;
    }
}

.audio-position-review {
    margin-top: 3px;
    width: 300px;
}
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .audio-position-review{
            width: 100%;
        }
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
    border-top: 40px solid #733cff;
    border-left: 40px solid transparent;
}
.Promo {
    /*三角形右上*/
    position: absolute;
    /* transform: translateX(24px); */
    top: 0;
    right: 0;
    border-top: 44px solid #733cff;
    border-left: 44px solid transparent;
}
.Promo-Text {
    position: absolute;
    top: 36px;
    right: 3px;
    transform: translateY(-40px);
    color: #ffffff;
    font-size: 16px;
}

.day {
    padding-top: 10px;
    text-align: right;
}
</style>

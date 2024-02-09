<template>
    <v-row class="pl-3" justify="center">
        <v-col cols="auto" class="soto">
            <v-card class="mx-auto" max-width="570px" rounded="0" elevation="0" link
                :ripple="false" :to="{ name: 'post', params: { postId: post.id } }" @click="setPostDetail">
                <Title :name="post.USER_NAME" :myImg="'../../storage/user/' + post.USER_ID + '/' + post.ICON" :userId="post.USER_ID" :postId="post.id"/>
                <v-card-title>
                    {{ post.TITLE }}
                </v-card-title>
            
                <div class="aaa">
                    <v-img  class="postImg"
                        :src="'../../storage/post/' + post.id + '/' + post.IMAGES"></v-img>
                    <div v-if="windowWidth > 850" class="audio">
                        <audio controlslist="nodownload" class=" audio-position-free" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                    </div>
                    <div v-if="windowWidth <= 850" class="audio pt-1">
                        <audio controlslist="nodownload" class=" audio-position-free" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                    </div>
                </div>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="accodion($event)">
                        <v-icon :icon="show ? '$chevronUp' : '$chevronDown'"></v-icon>
                        <v-tooltip activator="parent" location="bottom" v-if="show" text="閉じる"  ></v-tooltip>
                        <v-tooltip activator="parent" location="bottom" v-if="!show" text="収録環境を表示"></v-tooltip>
                    </v-btn>
                </v-card-actions>
                <v-expand-transition>
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
                                <h2 >
                                    使用機材
                                </h2>
                                <v-list v-for="item in post.ITEMS" :key="item" :value="item" color="primary" class="py-0"  >
                                    <v-list-item class="py-1" width="570px" :padding="0"><div>■{{ item }}</div></v-list-item>
                                </v-list>
                            </div>
                            <div style="display: block;" class="mx-auto my-3 pb-2" >
                                <h2>
                                    録音方法
                                </h2>
                                <div class="mx-4">{{ post.RECORDING_METHOD }} </div>
                            </div>
                        </div>
                    </div>
                </v-expand-transition>
            </v-card>
            <v-divider length="570"></v-divider>
        </v-col>
    </v-row>
</template>

<script setup>
import Title from '@/Components/Title.vue'
</script>

<script>
export default {
    data: () => {
        return {
            show: false,
            reveal: false,
            windowWidth: window.innerWidth,
        }
    },
    mounted () {
        // 画面幅が切り替わる毎に関数呼び出し
        window.addEventListener('resize', this.resizeWindow)
    },
    methods: {
        // 現在の画面幅を変数の中に入れる
        resizeWindow(){
            this.windowWidth = window.innerWidth
        },
        // 使用機材、録音方法を開くとき遷移しない
        accodion: function (event) {
            event.preventDefault()
            this.show = !this.show
        },
        //投稿詳細のデータをセットする関数
        setPostDetail() {
            //ユーザーの投稿データをstore.jsのstateに保存
            this.$store.commit('addData', this.post);
        },
        notDo:function (event){
            event.preventDefault()
        },
    },
    props: {
        post: Object,
    }
}
</script>

<style>
.aaa {
    display: flex;
    gap: 6px;
    padding-left: 6px;
    width: auto;
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

.audio {
    width: 300px;
    margin-top: 70px;
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
    width: 300px;
}
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .audio-position-free{
            width: 100%;
        }
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

.add1 {
    width: 250px;
    margin-left: 20px;
}

.add2 {
    width: 250px;
}

.text-length {
    height: 120px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 6;
    /* 任意の行数を指定 */

}

.soto {
    padding: 0;
}


</style>

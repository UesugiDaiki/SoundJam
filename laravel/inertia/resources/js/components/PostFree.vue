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
                    <div class="audio">
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
                        <v-row no-gutters>
                            <div class="add1">
                                <h2>
                                    使用機材
                                </h2>
                                <v-list v-for="item in post.ITEMS" :key="item" :value="item" color="primary" class="py-0"  >
                                    <v-list-item class="py-1" width="250px" :padding="0"><div>■{{ item }}</div></v-list-item>
                                </v-list>
                            </div>
                            <v-divider vertical class="mx-4  border-opacity-25" inset></v-divider>
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
            <v-divider length="570"></v-divider>
        </v-col>
    </v-row>
</template>

<script setup>
import Title from '@/Components/Title.vue'
</script>

<script>
export default {
    data: () => ({
        show: false,
        reveal: false,
    }),
    methods: {
        // 使用機材、録音方法を開くとき遷移しない
        accodion: function (event) {
            event.preventDefault()
            this.show = !this.show
        },
        //投稿詳細のデータをセットする関数
        setPostDetail() {
            //ユーザーの投稿データをstore.jsのstateに保存
            this.$store.commit('addData', this.post);
        }
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
    margin-top: 3px;
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

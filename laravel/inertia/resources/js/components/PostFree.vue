<template>
    <v-row class="pl-3" justify="center">
        <v-col cols="auto" class="soto">
            <v-card class="mx-auto" width="570px" max-width="570" min-width="200" rounded="0" elevation="0" link
                :ripple="false" :to="{ name: 'post', params: { postId: this.post.id } }" @click="setPostDetail">
                <Title :name="post.USER_NAME" :myImg="'../../storage/user/' + post.USER_ID + '/' + post.ICON" :userId="post.USER_ID" :postId="post.id"/>
                <v-card-title>
                    {{ post.TITLE }}
                </v-card-title>
                <div class="aaa">
                    <v-img max-width="250" min-width="250" max-height="190" min-height="190"
                        :src="'../../storage/post/' + post.id + '/' + post.IMAGES"></v-img>
                    <div class="audio">
                        <audio controlslist="nodownload" class="audio-position-free" controls
                            :src="'../../storage/post/' + post.id + '/' + post.AUDIO1"></audio>
                    </div>
                </div>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :icon="show ? '$chevronUp' : '$chevronDown'" @click="accodion($event)"></v-btn>
                </v-card-actions>
                <v-expand-transition>
                    <div v-show="show">
                        <v-row no-gutters>
                            <div class="add1">
                                <h2>
                                    使用機材
                                </h2>
                                <v-list v-for="item in post.ITEMS" :key="item" :value="item" color="primary">
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
            <v-divider length="570"></v-divider>
        </v-col>
    </v-row>
</template>

<script setup>
import Title from '@/components/Title.vue'
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

.audio-position-free {
    margin-top: 80px;
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

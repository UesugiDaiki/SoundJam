<template>
<v-app-bar color="white" elevation="0">
    <v-btn class="ma-2" variant="text" icon="$arrowLeft" onclick="window.history.back();"></v-btn>
</v-app-bar>
<v-row align="center" justify="center">
    <v-col cols="auto" class="soto">
    <v-card class="mx-auto" width="570px" max-width="570" min-width="200" rounded="0" elevation="0" :ripple="false">
        <Title :name="post.USER_NAME" :myImg="'../../' + post.ICON" :title="post.TITLE" :userId="post.USER_ID"/>
        <v-card-subtitle class="day">
        2023/05/30
        </v-card-subtitle>

        <v-card-title>
        {{ post.TITLE }}
        <div class="Item-Content-Flg4"></div>
        </v-card-title>
        <div class="aaa">
        <v-img max-width="250" min-width="250" max-height="190" min-height="190" :src="'../../' + post.IMAGES">
        </v-img>
        <div class="audio">
            <audio controlslist="nodownload" class="audio-position" controls :src="'../../'+post.AUDIO1"></audio>
            <audio v-show="post.AUDIO2" controlslist="nodownload" class="audio-position" controls :src="'../../'+post.AUDIO2"></audio>
        </div>
        </div>

        <v-card-title>
        概要
        </v-card-title>
        <v-card-text>
        {{ post.OVERVIEW }}
        </v-card-text>
        <hr>
        <v-expand-transition class="mb-5">
        <div v-show="show">
            <v-text>
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
                <v-text>
                    {{ post.RECORDING_METHOD }}
                </v-text>
                </div>
            </v-row>
            </v-text>
        </div>
        </v-expand-transition>
        <LinkingPost v-for="renPost in post.CONNECT" :key="renPost" :title="renPost[0]" :img="'../../'+renPost[3]"
        :music1="'../../'+renPost[2]" :overview="renPost[1]" />

        <!-- <v-col v-if="motoPost.userId == 123" cols="auto" > -->
        <v-col  cols="auto" >
        <v-btn icon="$plusBoxOutline" elevation="0" style="float: right;"></v-btn>
        </v-col>
    </v-card>
    </v-col>
</v-row>
</template>

<script setup>
import Title from '@/components/Title.vue'
import LinkingPost from '@/components/LinkingPost.vue'
</script>

<script>
export default {
    //ページ読み込み時発動
    created() {
        //　storeに保存している投稿データを取得
        this.post = this.$store.state.postData;
        //デバッグ
        console.log(this.$store.state.postData);
        console.log(this.post.CONNECT);
        console.log(this.post.ITEMS);
    },
    data: () => ({
        //投稿データを保存するデータ
        post: Object,
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
text-align: right;
}
</style>

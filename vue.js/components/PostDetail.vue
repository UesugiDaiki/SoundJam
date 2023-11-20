<template>
  <v-row align="center" justify="center">
    <v-col cols="auto" class="soto">

      <v-card class="mx-auto" width="570px" max-width="570" min-width="200" rounded="0" elevation="0" :ripple="false">
        <Title :name="motoPost.name" :myImg="motoPost.myImg" :title="motoPost.title" />
        <v-card-subtitle class="day">
          2023/05/30
        </v-card-subtitle>

        <v-card-title>
          {{ motoPost.title }}
          <div class="Item-Content-Flg4"></div>
        </v-card-title>
        <div class="aaa">
          <v-img max-width="250" min-width="250" max-height="190" min-height="190" :src="motoPost.img">
          </v-img>
          <div class="audio">
            <audio controlslist="nodownload" class="audio-position" controls :src="motoPost.music1"></audio>
            <audio controlslist="nodownload" class="audio-position" controls :src="motoPost.music2"></audio>
          </div>
        </div>
        
        <v-card-title>
          概要
        </v-card-title>
        <v-card-text>
          {{ motoPost.overview }}
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
                  <v-list v-for="(item, i) in motoPost.items" :key="i" :value="item" color="primary">
                    <v-list-item-title :padding="0">■{{ item.text }}</v-list-item-title>
                  </v-list>
                </div>
                <v-divider vertical class="mx-4 border-opacity-25" inset></v-divider>
                <div class="add2">
                  <h2>
                    録音方法
                  </h2>
                  <v-text>
                    {{ motoPost.recording }}
                  </v-text>
                </div>
              </v-row>
            </v-text>
          </div>
        </v-expand-transition>
        <LinkingPost v-for="renPost in renPosts" :key="renPost" :title="renPost.title" :img="renPost.img"
        :music1="renPost.music1" :overview="renPost.overview" />
        
        <v-col v-if="motoPost.userId == 123" cols="auto" >
          <v-btn icon="$plusBoxOutline" elevation="0" style="float: right;"></v-btn>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>



<script setup>
import Title from '@/components/Title.vue'
// import like from '@/components/like.vue'
import LinkingPost from '@/components/LinkingPost.vue'
</script>

<script>
export default {
  data: () => ({
    show: true,
    reveal: false,
    motoPost: {
      ID: 1,
      PostId: 1,
      userId:123,
      name: "雅弥",
      myImg: "src/assets/masaya.png",
      title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
      img: "src/assets/ms50g.png",
      music1: "src/assets/maou_bgm_piano40.mp3",
      music2: "src/assets/maou_bgm_fantasy15.mp3",
      overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はファズを使ってみました。今回使用したファズは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
      recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
      items: [
        { text: 'YAMAHA REVSTAR420' },
        { text: 'CANARE シールド' },
        { text: 'BOSS MS-50g' },
        { text: 'CANARE シールド' },
        { text: 'PRESONUS Studio 24c' },
      ],
    },
    renPosts: [
      {
        ID: 2,
        PostId: 1,
        title: "ZOOM/ MS-50G のコーラス",
        img: "src/assets/ms50g.png",
        music1: "src/assets/maou_bgm_piano40.mp3",
        overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はコーラスを使ってみました。今回使用したコーラスは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
      },
      {
        ID: 3,
        PostId: 1,
        title: "ZOOM/ MS-50G の歪",
        img: "src/assets/ms50g.png",
        music1: "src/assets/maou_bgm_piano40.mp3",
        overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はコーラスを使ってみました。今回使用したコーラスは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
      },
    ]
  }),
  props: {
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
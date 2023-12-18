<template>


  <v-row  class="pl-3" justify="center">
      <v-card width="570px" rounded="0" elevation="0" :ripple="false">
        <v-card-text class="text-h6">
            {{ Post.name }}
          </v-card-text>
        <div align="center">
          <v-img max-width="250" min-width="250" max-height="190" min-height="190" :src="Post.img">
          </v-img>
          
        </div>
        <v-card-title>
          概要
        </v-card-title>
        <v-card-text>
          {{ Post.overview }}
        </v-card-text>
        <v-divider></v-divider>
      </v-card>
  </v-row>
</template>




<script>
export default {
  data: () => ({
    show: true,
    reveal: false,
    Post: {
      ID: 1,
      name: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
      img: "src/assets/ms50g.png",
      overview: "見た目は１個の小さなストンプボックスなのに、生み出せるサウンドは実に多彩。まるでどんなカードにもなるトランプのジョーカーのようなマルチなストンプペダルです。ペダルボードのストンプボックスたちと並べておけば、そのクリエイティビティは最大に。172種のエフェクトから最大６種類まで自由に組み合わせて同時使用が可能。MultiStomp MS-50G。ギター・イクイップメントに新しいカテゴリーが加わりました。",
      temp_regist: 1,
    },
    
    // motoPost: {

    //   ID: 1,
    //   PostId: 1,
    //   userId:123,
    //   name: "雅弥",
    //   myImg: "src/assets/masaya.png",
    //   title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
    //   img: "src/assets/ms50g.png",
    //   music1: "src/assets/maou_bgm_piano40.mp3",
    //   music2: "src/assets/maou_bgm_fantasy15.mp3",
    //   overview: "見た目は１個の小さなストンプボックスなのに、生み出せるサウンドは実に多彩。まるでどんなカードにもなるトランプのジョーカーのようなマルチなストンプペダルです。ペダルボードのストンプボックスたちと並べておけば、そのクリエイティビティは最大に。１72種のエフェクトから最大６種類まで自由に組み合わせて同時使用が可能。MultiStomp MS-50G。ギター・イクイップメントに新しいカテゴリーが加わりました。",
    //   recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
    //   items: [
    //     { text: 'YAMAHA REVSTAR420' },
    //     { text: 'CANARE シールド' },
    //     { text: 'BOSS MS-50g' },
    //     { text: 'CANARE シールド' },
    //     { text: 'PRESONUS Studio 24c' },
    //   ],
    // },
    // renPosts: [
    //   {
    //     ID: 2,
    //     PostId: 1,
    //     title: "ZOOM/ MS-50G のコーラス",
    //     img: "src/assets/ms50g.png",
    //     music1: "src/assets/maou_bgm_piano40.mp3",
    //     overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はコーラスを使ってみました。今回使用したコーラスは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
    //   },
    //   {
    //     ID: 3,
    //     PostId: 1,
    //     title: "ZOOM/ MS-50G の歪",
    //     img: "src/assets/ms50g.png",
    //     music1: "src/assets/maou_bgm_piano40.mp3",
    //     overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はコーラスを使ってみました。今回使用したコーラスは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
    //   },
    // ]
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

.aaaa {
  display: flex;
  gap: 6px;
  /* padding-left: 160px; */
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
  padding: 0px, 0px, 0px, 12px;
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
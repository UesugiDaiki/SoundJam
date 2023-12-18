<template>

<hr>
<v-card-title class="mt-4">
          {{ title }}
        </v-card-title>
        <div class="aaa">
          <v-img
            max-width="250"
            min-width="250"
            max-height="190"
            min-height="190"
            :src="img"
            >
          </v-img>
          <div class="audio">

            <v-card-title class="like">
              <like class="like"/>
            </v-card-title>
            <v-card-subtitle class="day">
              2023/05/30
            </v-card-subtitle>
            <audio controlslist="nodownload" class="audio-position" controls :src="music1"></audio>
          </div>
        </div>
        
        <v-card-title>
          概要
        </v-card-title>
        <v-card-text>
          {{ overview }}
        </v-card-text>




</template>



<script setup>
import like from '@/components/Like.vue'
</script>

<script>
export default {
  data: () => ({
    show: true,
    reveal: false,
  }),
  props: {
    post: Object,
    title: String,
    img: String,
    music1: String,
    overview: String,
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
  gap:6px;
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
  -webkit-line-clamp: 2; /* 任意の行数を指定 */
}
.soto {
  padding: 0;
}
.Item-Content-Flg4 {/*三角形右上*/
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
<template>
  <v-row class="pl-3">
    <v-col cols="auto" class="soto">
      <v-card class="mx-auto" width="570px" max-width="570" min-width="200" rounded="0" elevation="0"
        style="border: 1px solid #ddd;" link :ripple="false">
        <Title :name="post.name" :myImg="post.myImg" />
        <v-card-title>
          {{ post.title }}
          <div class="Item-Content-Flg4"></div>
        </v-card-title>
        <div class="aaa">
          <v-img max-width="250" min-width="250" max-height="190" min-height="190" :src="post.img"></v-img>
          <div class="audio">
            <audio controlslist="nodownload" class="audio-position" controls :src="post.music1"></audio>
            <audio controlslist="nodownload" class="audio-position" controls :src="post.music2"></audio>
          </div>
        </div>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :icon="show ? '$chevronUp' : '$chevronDown'" @click.stop="show = !show"></v-btn>
        </v-card-actions>
        <v-expand-transition>
          <div v-show="show">
              <v-row no-gutters>
                <div class="add1">
                  <h2>
                    使用機材
                  </h2>
                  <v-list v-for="(item, i) in post.items" :key="i" :value="item" color="primary">
                    <v-list-item-title :padding="0">■{{ item.text }}</v-list-item-title>
                  </v-list>
                </div>
                <v-divider vertical class="mx-4 border-opacity-25" inset></v-divider>
                <div class="add2">
                  <h2>
                    録音方法
                  </h2>
                    {{ post.recording }}
                </div>
              </v-row>
          </div>
        </v-expand-transition>
      </v-card>
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

.audio-position {
  margin-top: 20px;
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

.Item-Content-Flg4 {
  /*三角形右上*/
  position: absolute;
  top: 0;
  right: 0;
  border-top: 40px solid #5bc8ac;
  border-left: 40px solid transparent;
}
</style>

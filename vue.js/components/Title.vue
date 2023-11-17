<template>
  <v-card-title class="masaya">
    <router-link to="/">
      <v-img
        :width="47"
        :height="47"
        margin="auto"
        cover
        :src="my_img"
        class="title rounded-circle"
      ></v-img>
    </router-link>
    
    <v-card-title class="title name">
      {{ name }}
    </v-card-title>
      <like class="title iine" />
  </v-card-title>

  
</template>


<script setup>
import Like from '@/components/Like.vue'
</script>

<script>

export default {
  data: () => ({
    name: "雅弥",
    my_img: "src/assets/masaya.png"
  }),
}
</script>

<style>
.name {
  width: 300px;
  padding: 12px;
}

.iine {
  width: 100px;
  padding: 4px;
}

.title {
  float: left;
}


</style>
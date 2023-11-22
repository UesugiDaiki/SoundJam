<template>
  <v-card-title class="linking">
    <like class="title iine" />
  </v-card-title>

  
</template>


<script setup>
import like from '@/components/like.vue'
</script>

<script>

export default {
  data: () => ({
  }),
  props: {
    name: String,
    myImg: String
  }
}
</script>

<style>
.linking {
  width: 100px;
  
}
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
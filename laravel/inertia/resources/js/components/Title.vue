<template>
<v-card-title class="masaya">
    <router-link :to="{name: 'user', params: {userId: this.userId}}">
    <v-img
        :width="47"
        :height="47"
        margin="auto"
        cover
        :src="myImg"
        class="title rounded-circle"
    ></v-img>
    </router-link>

    <v-card-title class="title name">
    {{ name }}
    </v-card-title>
</v-card-title>
</template>

<script>
export default {
    props: {
        name: String,
        myImg: String,
        userId: Number,
        postId: Number,
    }
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

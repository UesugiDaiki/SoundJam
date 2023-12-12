<template>
    <v-card-title class="masaya">
        <router-link :to="{ name: 'user', params: { userId: this.userId } }">
            <v-img :width="47" :height="47" margin="auto" cover :src="myImg" class="title rounded-circle"></v-img>
        </router-link>

        <v-card-title class="title name">
            {{ name }}
        </v-card-title>
        <like class="title iine" />
        <div class="text-center">
            <v-menu v-model="menu" :close-on-content-click="false" location="end">
                <template v-slot:activator="{ props }">
                    <v-btn icon="$dotsHorizontal" v-bind="props" elevation="0" style="float: right;">
                    </v-btn>
                </template>

                <v-card class="mx-auto pa-2" max-width="300">
                    <v-list>
                        <div class="delete">
                            <v-list-item value="item" @click="onDeletePost">
                                <template v-slot:prepend>
                                    <v-icon icon="$delete"></v-icon>
                                </template>
                                <v-list-item-title text="投稿削除">投稿削除</v-list-item-title>









                            </v-list-item>
                        </div>

                        <v-list-item value="1">
                            <template v-slot:prepend>
                                <v-icon icon="$penPuls"></v-icon>
                            </template>
                            <v-list-item-title text="投稿削除">投稿編集</v-list-item-title>
                        </v-list-item>

                    </v-list>


                </v-card>
            </v-menu>
        </div>
    </v-card-title>

    <delete-post-dialog ref="delete"/>
</template>

<script setup>
import Like from '@/components/Like.vue'
import DeletePostDialog from './DeletePostDialog.vue';
</script>

<script>
export default {
    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
    }),
    props: {
        name: String,
        myImg: String,
        userId: Number,
    },
    methods: {
        onDeletePost() {
            console.log('onDeletePost')
            this.$refs.delete.openDelete()
        }
    }
}
</script>

<style>
.delete {
    color: red;
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

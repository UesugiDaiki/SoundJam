<template>
    <v-card-title class="masaya d-flex">
        <router-link v-if="post.id !== undefined" :to="{ name: 'user', params: { userId: post.USER_ID } }">
            <v-img :width="47" :height="47" margin="auto" cover :src="'../../storage/user/' + post.USER_ID + '/' + post.ICON" class="title rounded-circle"></v-img>
        </router-link>

        <v-card-title class="title name">
            {{ post.USER_NAME }}
        </v-card-title>
        <v-spacer></v-spacer>
        <v-btn color="error" variant="text" icon="$delete" v-if="loggedInAccount" @click="onDeletePost" elevation="0">
            <v-icon icon="$delete"></v-icon>
            <v-tooltip activator="parent" location="bottom" text="投稿を削除"></v-tooltip>
        </v-btn>
    </v-card-title>

    <delete-post-dialog ref="delete" :title="post.TITLE" :postId="post.id"/>
</template>

<script setup>
import DeletePostDialog from './DeletePostDialog.vue'
import axios from 'axios'
</script>

<script>
export default {
    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
        session: {data: null},
    }),
    props: {
        post: Object,
    },
    computed: {
        loggedInAccount() {
            return this.post.USER_ID === this.session.data
        }
    },
    async created() {
        this.session = await axios.get('/api/getSession')
    },
    methods: {
        // 投稿削除ダイアログ表示
        onDeletePost() {
            this.$refs.delete.openDialog()
        },
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

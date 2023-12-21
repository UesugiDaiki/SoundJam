<template>
    <v-card-title class="masaya">
        <router-link :to="{ name: 'user', params: { userId: post.USER_ID } }">
            <v-img :width="47" :height="47" margin="auto" cover :src="'../../storage/user/' + post.USER_ID + '/' + post.ICON" class="title rounded-circle"></v-img>
        </router-link>

        <v-card-title class="title name">
            {{ post.USER_NAME }}
        </v-card-title>
        <like class="title iine" />
        <div class="text-center">
            <v-menu v-model="menu" :close-on-content-click="false" location="end">
                <template v-slot:activator="{ props }" v-if="loggedInAccount">
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

                        <div class="editFree">
                            <v-list-item value="1" @click="onEditPostDialog">
                                <template v-slot:prepend>
                                    <v-icon icon="$penPuls"></v-icon>
                                </template>
                                <v-list-item-title text="投稿削除" >投稿編集</v-list-item-title>
                            </v-list-item>
                        </div>

                    </v-list>


                </v-card>
            </v-menu>
        </div>
    </v-card-title>

    <delete-post-dialog ref="delete" :title="post.TITLE" :postId="post.id"/>
    <edit-free-dialog ref="editFree" :post="post"/>
    <edit-review-dialog ref="editReview" :post="post"/>
</template>

<script setup>
import Like from '@/components/Like.vue'
import DeletePostDialog from './DeletePostDialog.vue';
import EditFreeDialog from './EditFreeDialog.vue';
import EditReviewDialog from './EditReviewDialog.vue';
import axios from 'axios';
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
            // console.log('onDeletePost')
            this.$refs.delete.openDialog()
        },
        // 投稿編集ダイアログ表示
        onEditPostDialog(){
            // レビューか自由か
            console.log(this.post.POST_TYPE)
            if(this.post.POST_TYPE){
                // レビュー投稿の場合
                console.log('onEditReviewPost')
                this.$refs.editReview.openDialog()
            }else{
                // 自由投稿の場合
                console.log('onEditFreePost')
                this.$refs.editFree.openDialog()
            }
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

<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" width="332px">
            <v-card>
                <!-- == 投稿のタイトルを持ってくる ==-->
                <v-card-text class="text-center  pt-5">「{{ title }}」</v-card-text>
                <!-- =============================== -->
                <v-card-title class="text-center pt-2">この投稿を削除しますか？</v-card-title>
                <v-card-item class="px-3 py-5  d-flex justify-center">
                    <v-btn color="error" class="mx-5" @click="deletePost"> 削除 </v-btn>
                    <v-btn variant="tonal" class="mx-5" @click="dialog = false">
                        閉じる
                    </v-btn>
                </v-card-item>
            </v-card>

        </v-dialog>
    </v-row>
    <v-snackbar v-model="snackbar"> {{ snackbarMessage }} </v-snackbar>
</template>


<script>
import axios from 'axios'

export default {
    data() {
        return {
            dialog: false,
            snackbar: false,
            snackbarMessage: '',
        }
    },
    props: {
        title: String,
        postId: String,
    },
    methods: {
        openDialog(){
            this.dialog = true
        },
        async deletePost(){
            this.dialog = false
            let successFlg = false
            await axios.post('/api/deletePost', {postId: this.postId})
                .then(function(response) {
                    successFlg = true
                })
                .catch(function(error) {
                    successFlg = false
                })

            if (successFlg) {
                this.snackbarMessage = '投稿を削除しました。'
            } else {
                this.snackbarMessage = '投稿の削除に失敗しました。'
            }
            this.snackbar = true
            
            window.history.back();
        }
    }
}
</script>

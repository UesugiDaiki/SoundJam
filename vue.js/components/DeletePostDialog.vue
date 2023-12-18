<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" width="332px">
            <!-- テスト用ボタン -->
            <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
            </template>
            <!--  -->
            <v-card>
                <!-- == 投稿のタイトルを持ってくる ==-->
                <!-- <v-card-text class="text-center  pt-5">エレキギターをアコギの音に！！！</v-card-text> -->
                <!-- <v-card-text class="text-center  pt-5"> この部分に持ってきたタイトル入れる </v-card-text> -->
                <!-- =============================== -->
                <v-card-title class="text-center pt-2">この投稿を削除しますか？</v-card-title>
                <v-card-subtitle class="text-center pt-2">※この投稿に連結している投稿も削除されます</v-card-subtitle>
                <v-card-item class="px-3 py-5  d-flex justify-center">
                    <v-btn color="error" class="mx-5" @click="deletePost"> 削除 </v-btn>
                    <v-btn variant="tonal" class="mx-5" @click="dialog = false">
                        閉じる
                    </v-btn>
                </v-card-item>
            </v-card>

        </v-dialog>
    </v-row>
</template>


<script>
export default {
    data() {
        return {
            dialog: false,
        }
    },
    methods: {
        openLogout(){
            this.dialog = true
        },
        deletePost(){
            console.log("削除")
            this.dialog = false
            // 投稿を削除する処理を書く
        }
    }
}
</script>

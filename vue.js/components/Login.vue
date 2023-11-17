<template>
    <v-row justify="center">
        <v-dialog v-model="loginDialog" width="380px">
            <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
            </template>
            <v-card class="loginPopUp">
                <v-card-title class="mx-4 mt-5">
                    <span class="text-h5  " >ログイン</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <!-- ログイン情報入力テキストボックス -->
                        <v-text-field label="メールアドレス/ユーザーID" required></v-text-field>
                        <v-text-field label="パスワード" type="password" required></v-text-field>
                        <!-- ログインボタン -->
                        <v-card-item class="mt-3  d-flex justify-center ">
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40">ログイン</v-btn>
                            <v-btn  class="mt-2  d-flex justify-center" width="200"  to="/" >アカウント登録</v-btn>
                        </v-card-item>
                        <!-- アカウント登録へ飛ぶリンク -->
                                                                                                                            <!--　↓新規登録の画面に飛ばすリンクに変える  -->
                    </v-container>
                    <v-btn variant="tonal" @click="loginDialog = false">&lt; タイムラインに戻る</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>


<script>
    export default {
        data: () => ({
        loginDialog: false,
        }),
    }


</script>

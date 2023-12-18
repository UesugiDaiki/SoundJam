<template>
    <v-row justify="center">
        <v-dialog v-model="loginDialog" width="380px">
            <v-card class="loginPopUp">
                <v-card-title class="mx-4 mt-5">
                    <span class="text-h5">ログイン</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <!-- ログイン情報入力テキストボックス -->
                        <v-text-field label="メールアドレス/ユーザーID" required></v-text-field>
                        <v-text-field v-model="loginPassword" label="パスワード" :type="showPass ? 'text' : 'password'"
                            :append-inner-icon="showPass ? '$eye' : '$eyeOff'" @click:append-inner="showPass = !showPass"
                            counter required></v-text-field>
                        <v-card-item class="mt-3 d-flex justify-center ">
                            <!-- ログインボタン -->
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40">ログイン</v-btn>
                            <!-- アカウント登録へ飛ぶボタン -->
                            <v-btn elevation="0" class="mt-2 d-flex justify-center" width="200" @click="openRegistDialog">アカウント登録</v-btn>
                        </v-card-item>
                    </v-container>
                    <v-btn variant="tonal" @click="loginDialog = false">&lt; 閉じる</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>

    <v-row justify="center">
        <v-dialog v-model="registDialog" width="400px">
            <v-card class="registerPopUp">
                <v-card-title class="mx-4 mt-4">
                    <span class="text-h5">新規登録</span>
                </v-card-title>
                <v-card-text class="pt-0">
                    <v-container>
                        <!-- ログイン情報入力テキストボックス -->
                        <v-text-field label="ユーザー名" :rules="[rules.required]"></v-text-field>
                        <v-text-field label="メールアドレス" type="email" :rules="[rules.required]"></v-text-field>
                        <v-text-field v-model="newPassword" label="パスワード" :type="show1 ? 'text' : 'password'"
                            hint="半角英数字8~16文字" :rules="[rules.required, rules.min, rules.max, rules.format]"
                            :append-inner-icon="show1 ? '$eye' : '$eyeOff'" @click:append-inner="show1 = !show1" counter>
                        </v-text-field>

                        <v-text-field v-model="checkPassword" label="パスワード再確認" :type="show2 ? 'text' : 'password'" 
                            :rules="[rules.required]" :append-inner-icon="show2 ? '$eye' : '$eyeOff'"
                            @click:append-inner="show2 = !show2"></v-text-field>
                        <v-card-item class="mt-1  d-flex justify-center ">
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40">登録</v-btn>
                        </v-card-item>
                    </v-container>
                    <v-btn variant="tonal" @click="registDialog = false">&lt; ログインに戻る</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            loginDialog: false,
            registDialog: false,
            showPass:false,      //ログインのパスワードの入力typeの切り替えに使用 
            show1: false,        //新規登録のパスワードの入力typeの切り替えに使用 
            show2: false,        //新規登録のパスワード再確認の入力typeの切り替えに使用 
            loginPassword: '',   //ログインのパスワードの入力内容が入る
            newPassword: '',     //新規登録のパスワードの入力内容が入る
            checkPassword: '',   //新規登録のパスワード再確認の入力内容が入る
            rules: {
                required: value => !!value || '必須入力です',
                min: v => v.length >= 8 || '最低8文字入力してください',
                max: v => v.length <= 16 || '最大文字数は16文字です',
                format:  v => /^[\w-]{8,72}$/.test(v) || '半角英数字のみ使用出来ます'
            },
        }
    },
    methods: {
        openLogin() {
            this.loginDialog = true
        },
        openRegistDialog() {
            this.registDialog = true
        }
    }
}
</script>

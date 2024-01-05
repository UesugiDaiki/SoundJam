<template>
    <!-- ログインダイアログ -->
    <v-row justify="center">
        <v-dialog v-model="loginDialog" min-width="380px" max-width="380">
            <v-card class="loginPopUp">
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="loginDialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="mx-4 mt-5">
                    <span class="text-h5">ログイン</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <!-- ログイン情報入力テキストボックス -->
                        <v-text-field v-model="loginID" label="メールアドレス/ユーザーID" :rules="[rules.required]"></v-text-field>
                        <v-text-field v-model="loginPass" label="パスワード" type="password" :rules="[rules.required]"></v-text-field>
                        <v-card-item class="mt-3 d-flex justify-center ">
                            <!-- ログインボタン -->
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40" elevation="0" :disabled="isEnterLogin"
                                @click="login">ログイン</v-btn>
                            <!-- アカウント登録へ飛ぶボタン -->
                            <v-btn class="mt-2 d-flex justify-center" width="200" elevation="0" @click="openRegistDialog">アカウント登録</v-btn>
                        </v-card-item>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>

    <!-- 新規登録ダイアログ -->
    <v-row justify="center">
        <v-dialog v-model="registDialog" min-width="400px" max-width="400px">
            <v-card class="registerPopUp">
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="registDialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="mx-4">
                    <span class="text-h5">新規登録</span>
                </v-card-title>
                <v-card-text class="pt-0">
                    <v-container class="pb-0">
                        <!-- 新規登録情報入力テキストボックス -->
                        <v-text-field v-model="registName" label="ユーザー名" :rules="[rules.required]"></v-text-field>
                        <v-text-field v-model="registMail" label="メールアドレス" type="email" :rules="[rules.required]"></v-text-field>
                        <v-text-field v-model="registPass" label="パスワード" :type="show1 ? 'text' : 'password'"
                            hint="半角英数字8~16文字" :rules="[rules.required, rules.min, rules.max,]"
                            :append-inner-icon="show1 ? '$eye' : '$eyeOff'" @click:append-inner="show1 = !show1" counter>
                        </v-text-field>

                        <v-text-field v-model="registCheckPass" label="パスワード再確認" :type="show2 ? 'text' : 'password'"
                            :rules="[rules.required]" :append-inner-icon="show2 ? '$eye' : '$eyeOff'"
                            @click:append-inner="show2 = !show2" :error="matchPassWord" :error-messages="matchPassWord ? 'パスワードが一致しません' : null"></v-text-field>
                        <v-card-item class="mt-1  d-flex justify-center ">
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40" :disabled="isEnterRegist" @click="regist">登録</v-btn>
                        </v-card-item>
                    </v-container>
                </v-card-text>
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
            // ダイアログ表示
            loginDialog: false,
            registDialog: false,
            // パスワードの表示切替
            show1: false,
            show2: false,
            // ログインフォーム
            loginID: '',
            loginPass: '',
            // 新規登録フォーム
            registName: '',
            registMail: '',
            registPass: '',
            registCheckPass: '',
            // 入力ルール
            rules: {
                required: value => !!value || '必須項目です',
                min: v => v.length >= 8 || '最低8文字入力してください',
                max: v => v.length <= 16 || '最大文字数は16文字です',
            },
            // スナックバー
            snackbar: false,
            snackbarMessage: '',
        }
    },
    computed: {
        // パスワードと確認パスワードの一致
        matchPassWord() {
            return this.registCheckPass !== '' && this.registPass !== this.registCheckPass
        },
        // ログインフォーム入力済か
        isEnterLogin() {
            return !(
                this.loginID?.trim()
                && this.loginPass?.trim()
            )
        },
        // 新規登録フォーム入力済か
        isEnterRegist() {
            return !(
                this.registName?.trim()
                && this.registMail?.trim()
                && this.registPass?.trim()
                && this.registCheckPass?.trim()
                && !this.matchPassWord
            )
        },
    },
    methods: {
        openLogin() {
            this.loginDialog = true
        },
        openRegistDialog() {
            this.registDialog = true
        },
        async login() {
            let loginData = {
                loginID: this.loginID,
                loginPass: this.loginPass,
            }

            let successFlg = false
            await axios.post('/api/login', loginData)
                .then(function(response) {
                    successFlg = true
                })
                .catch(function(error) {
                    successFlg = false
                })

            //axios.postの結果をコンソールで確認する場合、下をコメントアウト
            if (successFlg) {
                location.reload()
            } else {
                this.snackbarMessage = 'ユーザーIDもしくはパスワードが間違っています。'
                this.snackbar = true
            }
        },
        async regist() {
            let registData = {
                registName: this.registName,
                registMail: this.registMail,
                registPass: this.registPass,
            }

            let successFlg = false
            await axios.post('/api/regist', registData)
                .then(function(response) {
                    successFlg = true
                })
                .catch(function(error) {
                    successFlg = false
                })

            if (successFlg) {
                this.snackbarMessage = 'ユーザーを作成しました。'
            } else {
                this.snackbarMessage = 'ユーザーの作成に失敗しました。'
            }
            this.snackbar = true
            this.registDialog = false
        },
    }
}
</script>

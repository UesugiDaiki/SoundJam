<template>
    <v-row justify="center">
        <v-dialog v-model="registerDialog" width="400px">
            <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open RegisterDialog </v-btn>
            </template>
            <v-card class="registerPopUp">
                <v-card-title class="mx-4 mt-4">
                    <span class="text-h5" >新規登録</span>
                </v-card-title>
                <v-card-text class="pt-0">
                    <v-container>
                        <!-- ログイン情報入力テキストボックス -->
                        <v-text-field label="ユーザー名"  :rules="[rules.required,]" ></v-text-field>
                        <v-text-field label="メールアドレス" type="email" :rules="[rules.required]"></v-text-field>
                        <v-text-field 
                        v-model="password"
                        label="パスワード"
                        :type="show1 ? 'text' : 'password'"
                        hint="半角英数字8~16文字"
                        :rules="[rules.required, rules.min,rules.max,]"
                        :append-inner-icon="show1 ? '$eye' : '$eyeOff'"
                        @click:append-inner="show1 = !show1" 
                        counter
                        >
                        </v-text-field>
                        
                        <v-text-field
                            label="パスワード再確認" 
                            :type="show2 ? 'text' : 'password'"
                            type="checkPassWord" :rules="[rules.required]"
                            :append-inner-icon="show2 ? '$eye' : '$eyeOff'"
                            @click:append-inner="show2 = !show2" 
                        ></v-text-field>
                        <v-card-item class="mt-1  d-flex justify-center ">
                            <v-btn style="font-size: 16px;" color="black" width="200" height="40">登録</v-btn>
                        </v-card-item>
                    </v-container>
                    <v-btn variant="tonal" @click="registerDialog = false">&lt; ログインに戻る</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>


<script>
    export default {
    data() {
        return {
                registerDialog: false,
                show1: false,
                show2: false,
                password: '',
                checkPassWord: '',
                rules: {
                    required: value => !!value || '必須入力です',
                    min: v => v.length >= 8 || '最低8文字入力してください',
                    max: v => v.length <= 16 || '最大文字数は16文字です',
                    // matchPassWord: checkPassWord => password == checkPassWord || 'パスワードが一致しません' エラー出る,
                },
            }
        },
    }

</script>

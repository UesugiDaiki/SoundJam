<template>
    <v-list-item-title class="ma-4 text-h6">パスワード再設定</v-list-item-title>
    <v-divider></v-divider>
    <v-card rounded="0" elevation="0" class="registerPopUp">
        <v-card-title class="mx-4 mt-4">
            <span class="text-h6">新規登録</span>
        </v-card-title>
        <v-card-text class="pt-0">
            <v-container>
                <v-text-field v-model="beforePassword" label="現在のパスワード" :type="show1 ? 'text' : 'password'"
                    :rules="[rules.required]" :append-inner-icon="show1 ? '$eye' : '$eyeOff'"
                    @click:append-inner="show1 = !show1"></v-text-field>

                <v-text-field v-model="newPassword" label="新規パスワード" :type="show2 ? 'text' : 'password'" hint="半角英数字8~16文字"
                    :rules="[rules.required, rules.min, rules.max,]" :append-inner-icon="show2 ? '$eye' : '$eyeOff'"
                    @click:append-inner="show2 = !show2" counter></v-text-field>

                <v-text-field v-model="checkPassword" label="新規パスワード再確認" :type="show3 ? 'text' : 'password'"
                    :rules="[rules.required]" :append-inner-icon="show3 ? '$eye' : '$eyeOff'"
                    @click:append-inner="show3 = !show3"></v-text-field>
                <v-card-item class="mt-1  d-flex justify-center ">
                    <v-btn style="font-size: 16px;" color="black" width="200" height="40">パスワード変更</v-btn>
                </v-card-item>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            registerDialog: false,
            show1: false,
            show2: false,
            show3: false,
            beforePassword: '',
            checkPassword: '',
            newPassword: '',
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

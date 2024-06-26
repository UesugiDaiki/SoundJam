<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    プロフィール変更
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="12" class="pb-0">
                                <v-text-field  counter="14" v-model="_user.name" :rules="[userNameRules.required , userNameRules.userNameMax]">
                                    <template v-slot:label>ユーザー名<span style="color: red"> * </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-file-input prepend-icon="" show-size label="アイコン画像" prepend-inner-icon="$camera" hint="5MBまで" :error="sizeDetection"  @change="fileSelect"  accept=".png,.jpg"></v-file-input>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-text-field prepend-inner-icon="$link" :rules="[linkRules.urlCheck]" label="URLリンク" v-model="_user.website"></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-textarea counter="160" label="プロフィール" auto-grow rows="3" v-model="_user.profiles" :rules="[profileRules.profileMax]"></v-textarea>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn :disabled="errorDetection || urlCheckDetection || sizeDetection" variant="flat" class="me-4" type="submit" color="primary" @click="updateUser">
                                保存
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>

    <v-snackbar v-model="snackbar"> {{ snackbarMessage }} </v-snackbar>
</template>

<script>
export default {
    props: {
        user: Object,
    },
    data() {
        return {
            snackbar: false,
            snackbarMessage: '',
            dialog: false,
            setDialog: false,
            uploadImgSize:0,
            _user: {},
            jpUrlRule: /https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+/g,
            // ユーザー名入力ルール
            userNameRules: {
                required: value => !!value || '必須項目です',
                userNameMax: v => v.length <= 14 || '最大文字数は14文字です',
            },
            // プロフィール入力ルール
            profileRules: {
                profileMax: v => v.length <= 160 || '最大文字数は160文字です',
            },
            // リンク入力ルール
            linkRules: {
                urlCheck:value => {
                    // リンクが入力されている場合
                    if(this._user.website != ""){
                        return this.urlCheck(this._user.website) || "URLのみ入力可能です"
                    }
                },
            },
        }
    },
    methods: {
        // URLか判定
        urlCheck(str){
                //日本語を含むURLの正規表現
                const jpUrlPattern = /https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+/g;
                return jpUrlPattern.test(str);
        },

        //ファイル選択時の処理
        fileSelect: function(e) {
            //選択したファイルの情報を取得しプロパティに入れる
            this._user.icon = e.target.files[0];
            this.uploadImgSize = this._user.icon;
        },
        openEditProfile() {
            if (!this.setDialog) {
                this._user = {
                    name: this.user.USER_NAME,
                    website: this.user.WEBSITE,
                    profiles: this.user.PROFILES,
                    icon: this.user.ICON,
                }
                this.setDialog = true
            }
            this.dialog = true
        },
        async updateUser() {
            let formData = new FormData();
            formData.append('id', this.user.id);
            formData.append('name', this._user.name);
            formData.append('website', this._user.website);
            // formData.append('profiles', this._user.profiles ? this._user.profiles : "");
            formData.append('profiles', this._user.profiles);
            formData.append('icon', this._user.icon);

            let successFlg = false
            await axios.post('/api/updateUser', formData)
                .then(function(response) {
                    //ページリロード
                    location.reload();
                    successFlg = true
                })
                .catch(function(error) {
                    successFlg = false
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = '更新しました。'
            } else {
                this.snackbarMessage = '更新に失敗しました。'
            }
            this.snackbar = true
            this.dialog = false
        }
    },
    computed: {
        // サイズ超えたらボタン無効化
        sizeDetection(){
            //上限サイズ5MBを超えた場合
            if (this._user.icon.size > 5000000) {
                // ボタン無効化
                return true
            } else {
                return false
            }
        },
        
        // 入力に間違いがあるとボタン無効化するやつ
        errorDetection() {
            // 入力内容が正しい場合
            if(this._user.name != "" && this._user.name.length <= 14 && this._user.profiles.length <= 160){
                return false
            }
            // 入力が間違っている場合
            else{
                // 要素の無効化を正にするためtrueを返す
                return true
            }
        },
        // リンクが入力されていたらURLか判定しボタン無効化するか決める
        urlCheckDetection(){
            // 空白ではない場合
            if(this._user.website != ""){
                //-- URLか判定 --//
                // 入力内容がURLの場合
                if(this.urlCheck(this._user.website)){
                    return false
                }
                // 入力内容がURLではない場合
                else{
                    // ボタン無効化
                    return true
                }
            }
        }
    }
}
</script>

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
                                <v-text-field label="ユーザー名" v-model="_user.name"></v-text-field>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-file-input prepend-icon="" prepend-inner-icon="$camera" @change="fileSelect"></v-file-input>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-text-field prepend-inner-icon="$link" v-model="_user.website"></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-textarea label="プロフィール" rows="3" v-model="_user.profile"></v-textarea>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="updateUser">
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
            _user: {},
        }
    },
    methods: {
        //ファイル選択時の処理
        fileSelect: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this._user.icon = e.target.files[0];
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
            formData.append('profiles', this._user.profile);
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
            this.initialization()
        }
    }
}
</script>

<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640" height="515">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title>
                    <v-tabs v-model="tab">
                        <v-tab width="50%" value="free">お問い合わせ</v-tab>
                        <v-tab width="50%" value="review">プロモーション依頼</v-tab>
                    </v-tabs>
                </v-card-title>

                <v-card-text>
                    <v-window v-model="tab">
                        <!-- お問い合わせ -->
                        <v-window-item value="free">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="inquiry.title" label="件名" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea v-model="inquiry.overview" label="本文" required></v-textarea>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-15">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="question" v-on:click="dialog = false">
                                        送信
                                    </v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- プロモーション依頼 -->
                        <v-window-item value="review">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field v-model="review.title" label="タイトル" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                            hint="音声（エフェクターOFF）" @change="fileSelect_OFF" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                        @change="fileSelect_img" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                            hint="音声（エフェクターON）" @change="fileSelect_ON" required></v-file-input>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="review.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="review.recordingMethod" rows="2" label="録音方法"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in review.equips"
                                            :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'"
                                            :label="'機材' + String(equip.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.equips.length > 1" variant="flat" icon="$minus"
                                            @click="removeEquip(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="application" v-on:click="dialog = false">
                                        <!-- 投稿 -->
                                        申請
                                    </v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>
                    </v-window>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>

    <!-- 申請時のメッセージ -->
    <v-snackbar v-model="snackbar"> {{ snackbarMessage }} </v-snackbar>

</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            tab: null,
            // プロモ
            review: {
                title: "",
                overview: "",
                recordingMethod: "",
                fileSelectimg: null,
                fileSelectOFF: null,
                fileSelectON: null,
                equips: [
                    { index: 0, equip: "" },
                ],
            },
            // お問合せ用
            inquiry: {
                title: "",
                overview: "",
            },

            snackbar: false,
            snackbarMessage: '',
        }
    },
    methods: {
        openInquiry() {
            this.dialog = true
        },
        // 使用機材追加
        addEquip() {
            let newIndex = this.review.equips.length
            let newEquip = { index: newIndex, equip: '' }
            this.review.equips.push(newEquip)
        },
        // 使用機材削除
        removeEquip() {
            this.review.equips.pop()
        },

        // 画像ファイル選択時の処理
        fileSelect_img: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.fileSelectimg = e.target.files[0];
        },

        //音声ファイルOFF選択時の処理
        fileSelect_OFF: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.fileSelectOFF = e.target.files[0];
        },
        //音声ファイルON選択時の処理
        fileSelect_ON: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.fileSelectON = e.target.files[0];
        },

        //　問い合わせ送信処理1
        async question(){
            let formData = new FormData();
            formData.append('title',this.inquiry.title);
            formData.append('overview',this.inquiry.overview);
            formData.append('recordingMethod',this.inquiry.recordingMethod);
            formData.append('img',this.fileSelectimg);
            formData.append('music1',this.fileSelectOFF);
            formData.append('music2',this.fileSelectON);

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let successFlg = false;
            await axios.post('/api/question', formData, config)
                .then(function(response) {
                    successFlg = true;
                })
                .catch(function(error) {
                    successFlg = false;
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = 'お問い合わせを送信しました。';
            } else {
                this.snackbarMessage = 'お問い合わせの送信に失敗しました。';
            }
            this.snackbar = true;
        },
        // 申請処理0
        async application(){
            let formData = new FormData();

            formData.append('title',this.review.title);
            formData.append('overview',this.review.overview);
            formData.append('recordingMethod',this.review.recordingMethod);
            formData.append('img',this.fileSelectimg);
            formData.append('OFF',this.fileSelectOFF);
            formData.append('ON',this.fileSelectON);

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            //メッセージフラグ
            let successFlg = false;
            await axios.post('/api/application', formData, config)
                .then(function(response) {
                    successFlg = true;
                })
                .catch(function(error) {
                    successFlg = false;
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = '申請を送信しました。';
            } else {
                this.snackbarMessage = '申請の送信に失敗しました。';
            }
            this.snackbar = true;
        }
    }
}
</script>

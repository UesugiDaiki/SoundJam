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
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="free.title" required :rules="[rules.required]">
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" ref="previewFree"
                                            hint="(5MBまで)" @change="fileSelect2" v-on:change="showFree" accept=".png,.jpg"
                                            show-size v-model="free.imageName" persistent-hint :error="imgRuleFree" required
                                            :rules="[rules.required]">
                                            <template v-slot:label>画像<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 上げた画像表示 -->
                                        <div class="previewFree-box" style="margin-bottom: 22px" v-if="urlFree">
                                            <v-img class="image-previewFree mx-auto" v-bind:src="urlFree" max-width="300"
                                                min-width="300" max-height="220" min-height="220"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!--　音声ファイル選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="(10MBまで)" required :rules="[rules.required]" ref="playFree" show-size
                                            v-model="free.audioName" @change="fileSelect1" v-on:change="playFree"
                                            persistent-hint :error="audioRuleFree">
                                            <template v-slot:label>音声<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 上げた音声表示 -->
                                        <div class="playFree-box" v-if="audioUrlFree"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playFree " controls
                                                v-bind:src="audioUrlFree"></audio>
                                        </div>
                                    </v-col>
                                    <!-- 概要 -->
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="free.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 録音方法 -->
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="free.recordingMethod" rows="2"
                                            label="録音方法"></v-textarea>
                                    </v-col>
                                    <!-- 機材 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in free.equips" v-model="free.equips[equip.index].equip"
                                            :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'"
                                            :label="'機材' + String(equip.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="free.equips.length > 1" variant="flat" icon="$minus"
                                            @click="removeEquip"></v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postFree"
                                        v-on:click="dialog = false" :disabled="isEnterFree">
                                        投稿
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
            audioUrlFree: "",    //自由投稿
            urlFree: "",          //自由投稿
            imgRuleFree: false,     //自由投稿
            audioRuleFree: false,     //自由投稿
            // 入力ルール
            rules: {
                required: value => !!value || '必須項目です',
            },
            free: {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio: null,
                audioName: [],
                // 画像
                image: null,
                imageName: [],
                equips: [
                    { index: 0, equip: "" },
                ],
            },
            equipsFreeCounter: 0,

            // お問合せ用
            inquiry: {
                title: "",
                overview: "",
            },

            snackbar: false,
            snackbarMessage: '',
        }
    },
    computed: {
        isEnterFree() {
            if (
                this.free.title?.trim()
                && this.free.audioName.length
                && this.free.imageName.length
            ) {
                return false
            } else {
                return true
            }
        },
    },
    methods: {
        openInquiry() {
            this.dialog = true
        },
        // 使用機材追加
        addEquip() {
            let newIndex = this.free.equips.length
            let newequip = { index: newIndex, equip: '' }
            this.free.equips.push(newequip)
        },
        // 使用機材削除
        removeEquip() {
            this.free.equips.pop()
        },
        //音声ファイル選択時の処理
        fileSelect1: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.free.audio = e.target.files[0];
        },
        // 画像ファイル選択時の処理
        fileSelect2: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.free.image = e.target.files[0];
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

        // 申請処理
        async postFree() {
            //自由投稿データ
            let formData = new FormData();
            formData.append('title', this.free.title);
            formData.append('overview', this.free.overview);
            formData.append('recordingMethod', this.free.recordingMethod);
            formData.append('mp3', this.free.audio);
            formData.append('img', this.free.image);
            let i = 0;
            for (i = 0; i < this.free.equips.length; i++) {
                formData.append('equip' + i, this.free.equips[i]["equip"]);
                //機材追加数計測カウンター
                this.equipsFreeCounter++;
            }
            //機材数を格納
            formData.append('equipsCounter', this.equipsFreeCounter);
            
            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let successFlg = false
            await axios.post('/api/application', formData, config)
                .then(function (response) {
                    successFlg = true
                })
                .catch(function (error) {
                    successFlg = false
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = '申請しました。'
            } else {
                this.snackbarMessage = '申請に失敗しました。'
            }
            this.snackbar = true
            this.dialog = false
            this.initialization()
        },

        // === 画像ファイルプレビュー === //
        // 自由投稿
        showFree() {
            const fileFree = this.$refs.previewFree.files[0];
            this.urlFree = URL.createObjectURL(fileFree);
            //上限サイズは5MB
            if (fileFree.size > 5000000) {
                // エラー表示
                this.imgRuleFree = true
            } else {
                this.imgRuleFree = false
            }
        },
        // === 音声ファイルプレビュー === //
        // 自由投稿
        playFree() {
            const fileAudioFree = this.$refs.playFree.files[0];
            this.audioUrlFree = URL.createObjectURL(fileAudioFree);
            //上限サイズは10MB
            if (fileAudioFree.size > 10000000) {
                this.audioRuleFree = true
            } else {
                this.audioRuleFree = false
            }
        },
        // プロパティ初期化
        initialization() {
            this.dialog = false
            this.tab = null
            this.audioUrlFree = ""    //自由投稿
            this.urlFree = ""          //自由投稿
            this.imgRuleFree = false     //自由投稿
            this.audioRuleFree = false     //自由投稿
            this.free = {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio: null,
                audioName: [],
                // 画像
                image: null,
                imageName: [],
                equips: [
                    { index: 0, equip: "" },
                ],
            },
            this.equipsFreeCounter = 0,

            // お問合せ用
            this.inquiry = {
                title: "",
                overview: "",
            }
        }

    }
}
</script>

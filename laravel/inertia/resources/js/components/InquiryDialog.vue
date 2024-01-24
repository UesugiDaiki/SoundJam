<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="690" height="515">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title>
                    <v-tabs v-model="tab">
                        <v-tab width="50%" value="inquiryPost">お問い合わせ</v-tab>
                        <v-tab width="50%" value="promotionPost">プロモーション依頼</v-tab>
                    </v-tabs>
                </v-card-title>

                <v-card-text>
                    <v-window v-model="tab">
                        <!-- お問い合わせ -->
                        <v-window-item value="inquiryPost">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="inquiry.title" label="件名" counter="40" :rules="[rules.required,rules.max]"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea v-model="inquiry.overview" label="本文" counter="160" auto-grow  :rules="[rules.required,mainRules.max]"></v-textarea>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-15">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="question" v-on:click="dialog = false" :disabled="inputError">
                                        送信
                                    </v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- プロモーション依頼 -->
                        <v-window-item value="promotionPost">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="promotion.title" :rules="[rules.required,titleRules.max]" counter="25">
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera"
                                            v-model="promotion.imageName" hint="(5MBまで)" persistent-hint accept=".png,.jpg"
                                            @change="fileSelectImg" v-on:change="showPromotion" ref="previewPromotion" show-size
                                            :rules="[rules.required]" :error="imgRulePromotion">
                                            <template v-slot:label>画像<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 画像プレビュー -->
                                        <div class="previewPromotion-box" v-if="urlPromotion">
                                            <v-img class="image-previewPromotion" v-bind:src="urlPromotion" max-width="300"
                                                min-width="275" max-height="220" min-height="220"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 音声ファイル１ -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            v-model="promotion.audio1Name" persistent-hint hint="(10MBまで)"
                                            :rules="[rules.required]" ref="playPromotion1" show-size @change="fileSelectAudio1"
                                            v-on:change="playPromotion1" :error="audioRulePromotion1">
                                            <template v-slot:label>音声1<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 上げた音声表示１ -->
                                        <div class="playPromotion1-box" v-if="audioUrlPromotion1"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playPromotion1  " controls
                                                v-bind:src="audioUrlPromotion1"></audio>
                                        </div>
                                        <!-- 音声ファイル2 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            v-model="promotion.audio2Name" persistent-hint hint="(10MBまで)"
                                            ref="playPromotion2" show-size @change="fileSelectAudio2"
                                            v-on:change="playPromotion2" :error="audioRulePromotion2">
                                            <template v-slot:label>音声2</template>
                                        </v-file-input>
                                        <!-- 上げた音声表示2 -->
                                        <div class="playPromotion2-box" v-if="audioUrlPromotion2"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playPromotion2  " controls
                                                v-bind:src="audioUrlPromotion2"></audio>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="promotion.overview" rows="2" label="概要"
                                            :rules="[rules.required,overviewRules.max]"  counter="160">
                                            <template v-slot:label>概要<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="promotion.recordingMethod" rows="2" label="録音方法"
                                            :rules="[rules.required,recordingMethodRules.max]" counter="160" >
                                            <template v-slot:label>録音方法<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>

                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in promotion.equips"
                                            v-model="promotion.equips[equip.index].equip"
                                            :hint="String(equip.index + 1) + 'つ目の機材名'"
                                            :rules="[rules.required,equipsRules.max]" counter="30">
                                            <template v-slot:label>機材{{ equip.index + 1 }}<span style="color: red"> *
                                                </span>
                                            </template>
                                        </v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip(tab)">
                                            <v-icon icon="$plus"></v-icon>
                                            <v-tooltip activator="parent" location="right" text="機材を追加"></v-tooltip>
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="promotion.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)">
                                            <v-icon icon="$minus"></v-icon>
                                            <v-tooltip activator="parent" location="right" text="機材を減らす"></v-tooltip>
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postPromotion"
                                        v-on:click="dialog = false" :disabled="isEnterPromotion || inputErrorPromotion">
                                        投稿の申請
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
            audioUrlPromotion1: "", //プロモーション投稿内の１つ目
            audioUrlPromotion2: "", //プロモーション投稿内の２つ目
            urlPromotion: "",        //プロモーション投稿
            imgRulePromotion: false,     //プロモーション投稿
            audioRulePromotion: false,     //プロモーション投稿
            // 入力ルール
            rules: {
                required: value => !!value || '必須項目です',
                max: v => v.length <= 40 || '最大文字数は40文字です',
                
            },
            mainRules:{
                max: v => v.length <= 160 || '最大文字数は160文字です',
            },
            titleRules:{
                max: v => v.length <= 25 || '最大文字数は25文字です',
            },
            // 概要
            overviewRules:{
                max: v => v.length <= 160 || '最大文字数は160文字です',
            },
            // 録音方法
            recordingMethodRules:{
                max: v => v.length <= 160 || '最大文字数は160文字です',
            },
            // 機材
            equipsRules:{
                max: v => v.length <= 30 || '最大文字数は30文字です',
            },
            // 投稿データ
            promotion: {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio1: null,
                audio1Name: [],
                audio2: null,
                audio2Name: [],
                // 画像
                image: null,
                imageName: [],
                equips: [
                    { index: 0, equip: "" },
                ],
            },
            equipsPromotionCounter: 0,

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
        // お問い合わせの入力制限
        inputError() {
            return !(
                this.inquiry.title != ""
                && this.inquiry.overview != ""
                && this.inquiry.title.length <= 40
                && this.inquiry.overview.length <= 160
            )
        },
        // プロモーション投稿の必須項目チェック
        isEnterPromotion() {
            if (
                this.promotion.title?.trim()
                && this.promotion.imageName.length
                && this.promotion.audio1Name.length
                && this.promotion.overview?.trim()
                && this.promotion.recordingMethod?.trim()
                // && existEquip
            ) {
                return false
            } else {
                return true
            }
        },
        // プロモーション投稿の入力内容に不具合が無いか確認
        inputErrorPromotion() {
            console.log(this.promotion)
            if (
                this.promotion.title.length <= 25
                && this.promotion.overview.length <= 160
                && this.promotion.recordingMethod.length <= 160
                && this.promotion.image.size <= 5000000
                && this.promotion.audio1.size <= 10000000
            ) {return false}
            else{return true
            }
        },
    },
    methods: {
        openInquiry() {
            this.dialog = true
        },
        // 使用機材追加
        addEquip() {
            let newIndex = this.promotion.equips.length
            let newequip = { index: newIndex, equip: '' }
            this.promotion.equips.push(newequip)
        },
        // 使用機材削除
        removeEquip() {
            this.promotion.equips.pop()
        },
        //音声ファイル1選択時の処理
        fileSelectAudio1: function (e) {
            console.log(this.promotion)

            //選択したファイルの情報を取得しプロパティにいれる
            this.promotion.audio1 = e.target.files[0];
            console.log(this.promotion)

        },
        //音声ファイル2選択時の処理
        fileSelectAudio2: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.promotion.audio2 = e.target.files[0];
        },
        // 画像ファイル選択時の処理
        fileSelectImg: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.promotion.image = e.target.files[0];
        },

        
        //=== お問い合わせ送信 ===// 
        //　問い合わせ送信処理
        async question(){
            let formData = new FormData();
            formData.append('title',this.inquiry.title);
            formData.append('overview',this.inquiry.overview);
            
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
            
            // 入力内容の初期化
            this.initialization()  
        },
        //==== プロモーション投稿送信 ===
        // 申請処理
        async postPromotion() {
            //プロモーション投稿データ
            let formData = new FormData();
            formData.append('title', this.promotion.title);
            formData.append('overview', this.promotion.overview);
            formData.append('recordingMethod', this.promotion.recordingMethod);
            formData.append('img', this.promotion.image);
            formData.append('mp3_1', this.promotion.audio1);
            formData.append('mp3_2', this.promotion.audio2);
            let i = 0;
            for (i = 0; i < this.promotion.equips.length; i++) {
                formData.append('equip' + i, this.promotion.equips[i]["equip"]);
                //機材追加数計測カウンター
                this.equipsPromotionCounter++;
            }
            //機材数を格納
            formData.append('equipsCounter', this.equipsPromotionCounter);
            
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
                // 入力内容の初期化
                this.initialization()
        },

        // === 画像ファイルプレビュー === //
        // プロモーション投稿
        showPromotion() {
            const filePromotion = this.$refs.previewPromotion.files[0];
            this.urlPromotion = URL.createObjectURL(filePromotion);
            //上限サイズは5MB
            if (filePromotion.size > 5000000) {
                // エラー表示
                this.imgRulePromotion = true
            } else {
                this.imgRulePromotion = false
            }
        },
        // === 音声ファイルプレビュー === //
        // プロモーション投稿音声１
        playPromotion1() {
            const fileAudioPromotion1 = this.$refs.playPromotion1.files[0];
            this.audioUrlPromotion1 = URL.createObjectURL(fileAudioPromotion1);
            //上限サイズは10MB
            if (fileAudioPromotion1.size > 10000000) {
                this.audioRulePromotion1 = true
            } else {
                this.audioRulePromotion1 = false
            }
        },
        // プロモーション投稿音声２
        playPromotion2() {
            const fileAudioPromotion2 = this.$refs.playPromotion2.files[0];
            this.audioUrlPromotion2 = URL.createObjectURL(fileAudioPromotion2);
            //上限サイズは10MB
            if (fileAudioPromotion2.size > 10000000) {
                this.audioRulePromotion2 = true
            } else {
                this.audioRulePromotion2 = false
            }
        },
        //=== プロパティ初期化 ===//
        initialization() {
            this.dialog = false
            this.tab = null
            this.audioUrlPromotion1 = ""
            this.audioUrlPromotion2 = "" 
            this.urlPromotion = ""        
            this.imgRulePromotion = false     
            this.audioRulePromotion = false     

            // お問い合せ用
            this.inquiry = {
                title: "",
                overview: "",
            }
            // プロモーション投稿データ
            this.promotion = {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio1: null,
                audio1Name: [],
                audio2: null,
                audio2Name: [],
                // 画像
                image: null,
                imageName: [],
                equips: [
                    { index: 0, equip: "" },
                ],
            }
            this.equipsPromotionCounter = 0
        },
    },
}
</script>

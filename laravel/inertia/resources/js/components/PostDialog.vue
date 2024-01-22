<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="690" height="515">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" v-on:click="initialization" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title>
                    <v-tabs v-model="tab">
                        <v-tab width="50%" value="free">自由投稿</v-tab>
                        <v-tab width="50%" value="review">レビュー投稿</v-tab>
                    </v-tabs>
                </v-card-title>

                <v-card-text>
                    <v-window v-model="tab">
                        <!-- ======== 自由投稿 ========  -->
                        <v-window-item value="free">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0" >
                                        <v-text-field v-model="free.title" :rules="[rules.required,titleRules.max]" counter="25" >
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" ref="previewFree"
                                            hint="(5MBまで)" @change="fileSelect2" v-on:change="showFree" accept=".png,.jpg"
                                            show-size v-model="free.imageName" persistent-hint :error="imgRuleFree" 
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
                                            hint="(10MBまで)" :rules="[rules.required]" ref="playFree" show-size
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
                                        <v-textarea counter="160" :rules="[overviewRules.max]" auto-grow v-model="free.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 録音方法 -->
                                    <v-col cols="6" class="py-0">
                                        <v-textarea counter="160" :rules="[recordingMethodRules.max]" auto-grow v-model="free.recordingMethod" rows="2"
                                            label="録音方法"></v-textarea>
                                    </v-col>
                                    <!-- 機材 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field :rules="[equipsRules.max]" counter="30" v-for="equip in free.equips" v-model="free.equips[equip.index].equip"
                                            :hint=" String(equip.index + 1) + 'つ目の機材名'"
                                            :label="'機材' + String(equip.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip(tab)">
                                            <v-icon icon="$plus"></v-icon>
                                            <v-tooltip activator="parent" location="right" text="機材を追加"></v-tooltip>
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="free.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)">
                                            <v-icon icon="$minus"></v-icon>
                                            <v-tooltip activator="parent" location="right" text="機材を減らす"></v-tooltip>
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postFree"
                                        v-on:click="dialog = false" :disabled="isEnterFree || inputErrorFree  ">
                                        投稿
                                    </v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- ======== レビュー投稿 ======== -->
                        <v-window-item value="review">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="review.product" :rules="[rules.required,titleRules.max]" counter="25">
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera"
                                            v-model="review.imageName" hint="(5MBまで)" persistent-hint accept=".png,.jpg"
                                            @change="fileSelect3" v-on:change="showReview" ref="previewReview" show-size
                                            :rules="[rules.required]" :error="imgRuleReview">
                                            <template v-slot:label>画像<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 画像プレビュー -->
                                        <div class="previewReview-box" v-if="urlReview">
                                            <v-img class="image-previewReview" v-bind:src="urlReview" max-width="300"
                                                min-width="300" max-height="220" min-height="220"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 音声ファイル１ -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            v-model="review.audio1Name" persistent-hint hint="(10MBまで)"
                                            :rules="[rules.required]" ref="playReview1" show-size @change="fileSelect1_1"
                                            v-on:change="playReview1" :error="audioRuleReview1">
                                            <template v-slot:label>音声1<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 上げた音声表示１ -->
                                        <div class="playReview1-box" v-if="audioUrlReview1"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playReview1  " controls
                                                v-bind:src="audioUrlReview1"></audio>
                                        </div>
                                        <!-- 音声ファイル2 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            v-model="review.audio2Name" persistent-hint hint="(10MBまで)"
                                            ref="playReview2" show-size @change="fileSelect2_2"
                                            v-on:change="playReview2" :error="audioRuleReview2">
                                            <template v-slot:label>音声2</template>
                                        </v-file-input>
                                        <!-- 上げた音声表示2 -->
                                        <div class="playReview2-box" v-if="audioUrlReview2"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playReview2  " controls
                                                v-bind:src="audioUrlReview2"></audio>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="review.overview" rows="2" label="概要"
                                            :rules="[rules.required,overviewRules.max]"  counter="160">
                                            <template v-slot:label>概要<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="review.recordingMethod" rows="2" label="録音方法"
                                            :rules="[rules.required,recordingMethodRules.max]" counter="160" >
                                            <template v-slot:label>録音方法<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>

                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in review.equips"
                                            v-model="review.equips[equip.index].equip"
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
                                        <v-btn v-if="review.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)">
                                            <v-icon icon="$minus"></v-icon>
                                            <v-tooltip activator="parent" location="right" text="機材を減らす"></v-tooltip>
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="editReview"
                                        v-on:click="dialog = false" :disabled="isEnterReview || inputErrorReview">
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

    <v-snackbar v-model="snackbar"> {{ snackbarMessage }} </v-snackbar>
</template>

<script>
export default {
    data() {
        return {
            // 音声プレビュー用
            audioUrlFree: "",    //自由投稿
            audioUrlReview1: "", //レビュー投稿内の１つ目
            audioUrlReview2: "", //レビュー投稿内の２つ目
            // 画像プレビュー用
            urlFree: "",          //自由投稿
            urlReview: "",        //レビュー投稿
            // 画像サイズ制限用
            imgRuleFree: false,     //自由投稿
            imgRuleReview: false,   //レビュー投稿
            // 音声サイズ制限用
            audioRuleFree: false,     //自由投稿
            audioRuleReview1: false,   //レビュー投稿の１つ目
            audioRuleReview2: false,   //レビュー投稿の２つ目

            // 入力ルール //
            rules: {
                required: value => !!value || '必須項目です',
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

            snackbar: false,
            snackbarMessage: '',
            dialog: false,
            tab: null,
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
            review: {
                // タイトル
                product: "",
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
            //機材追加数計測カウンター
            equipsReviewCounter: 0,
            equipsFreeCounter: 0,
        }
    },
    computed: {
        // 自由投稿の必須項目入力済か
        isEnterFree() {
            if (
                this.free.title?.trim()
                && this.free.audioName.length
                && this.free.imageName.length
            
            ){ return false } 
            else{return true} 
        },
        // 自由投稿の入力内容に不具合が無いか確認
        inputErrorFree() {
            if (
                this.free.title.length <= 25
                && this.free.overview.length <= 160
                && this.free.recordingMethod.length <= 160
                && this.free.image.size <= 5000000
                && this.free.audio.size <= 10000000
                // エラー　＊＊＊＊＊＊＊＊＊＊
                // && this.free.equips[1].equip.length <= 30
            ) {return false}
            else{return true}
        },
        // レビュー投稿の必須項目入力済か
        isEnterReview() {
            let existEquip = true
            for (let i = 0; i < this.review.equips.length; i++) {
                if (this.review.equips[i].equip === '') {
                    existEquip = true
                }
            }

            if (
                this.review.product?.trim()
                && this.review.overview?.trim()
                && this.review.recordingMethod?.trim()
                && this.review.audio1Name.length
                && this.review.imageName.length
                && this.review.audio1Name.length
                && existEquip
            ) {
                return false
            } else {
                return true
            }
        },
        // レビュー投稿の入力内容に不具合が無いか確認
        inputErrorReview() {
            if (
                this.review.product.length <= 25
                && this.review.overview.length <= 160
                && this.review.recordingMethod.length <= 160
                && this.review.image.size <= 5000000
                && this.review.audio1.size <= 10000000
                // エラー　＊＊＊＊＊＊＊＊＊＊
                // && this.review.equips[1].equip.length <= 30
            ) {return false}
            else{return true}
        },
    },
    methods: {
        openPost() {
            this.dialog = true
        },
        // 使用機材追加
        addEquip(type) {
            if (type === 'free') {
                let newIndex = this.free.equips.length
                let newequip = { index: newIndex, equip: '' }
                this.free.equips.push(newequip)
            } else if (type === 'review') {
                let newIndex = this.review.equips.length
                let newequip = { index: newIndex, equip: '' }
                this.review.equips.push(newequip)
            }
        },
        // 使用機材削除
        removeEquip(type) {
            if (type === 'free') {
                this.free.equips.pop()
            } else if (type === 'review') {
                this.review.equips.pop()
            }
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
        // 画像ファイル選択時の処理
        fileSelect3: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.review.image = e.target.files[0];
        },

        //音声ファイル1選択時の処理
        fileSelect1_1: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.review.audio1 = e.target.files[0];
        },

        //音声ファイル2選択時の処理
        fileSelect2_2: function (e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.review.audio2 = e.target.files[0];
        },

        // 自由投稿
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
            await axios.post('/api/postFree', formData, config)
                .then(function (response) {
                    successFlg = true
                })
                .catch(function (error) {
                    successFlg = false
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = '投稿しました。'
            } else {
                this.snackbarMessage = '投稿に失敗しました。'
            }
            this.snackbar = true
            this.dialog = false
            this.initialization()
        },


        // レビュー投稿処理
        async editReview() {
            //レビュー投稿データ
            let formData = new FormData();
            formData.append('product', this.review.product);
            formData.append('overview', this.review.overview);
            formData.append('recordingMethod', this.review.recordingMethod);
            formData.append('mp3_1', this.review.audio1);
            formData.append('mp3_2', this.review.audio2);
            formData.append('img', this.review.image);
            let i = 0;
            for (i = 0; i < this.review.equips.length; i++) {
                formData.append('equip' + i, this.review.equips[i]["equip"]);
                //機材追加数計測カウンター
                this.equipsReviewCounter++;
            }
            //機材数を格納
            formData.append('equipsCounter', this.equipsReviewCounter);

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let successFlg = false
            await axios.post('/api/postReview', formData, config)
                .then(function (response) {
                    successFlg = true
                })
                .catch(function (error) {
                    successFlg = false
                })

            // メッセージ表示
            if (successFlg) {
                this.snackbarMessage = '投稿しました。'
            } else {
                this.snackbarMessage = '投稿に失敗しました。'
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

        // レビュー投稿
        showReview() {
            const fileReview = this.$refs.previewReview.files[0];
            this.urlReview = URL.createObjectURL(fileReview);
            //上限サイズは5MB
            if (fileReview.size > 5000000) {
                this.imgRuleReview = true
            } else {
                this.imgRuleReview = false
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
        // レビュー投稿１
        playReview1() {
            const fileAudioReview1 = this.$refs.playReview1.files[0];
            this.audioUrlReview1 = URL.createObjectURL(fileAudioReview1);
            //上限サイズは10MB
            if (fileAudioReview1.size > 10000000) {
                this.audioRuleReview1 = true
            } else {
                this.audioRuleReview1 = false
            }
        },
        // レビュー投稿２
        playReview2() {
            const fileAudioReview2 = this.$refs.playReview2.files[0];
            this.audioUrlReview2 = URL.createObjectURL(fileAudioReview2);
            //上限サイズは10MB
            if (fileAudioReview2.size > 10000000) {
                this.audioRuleReview2 = true
            } else {
                this.audioRuleReview2 = false
            }
        },

        // 投稿ダイアログ初期化
        initialization() {
            this.audioUrlFree = ""          //自由投稿
            this.audioUrlReview1 = ""       //レビュー投稿内の１つ目
            this.audioUrlReview2 = ""       //レビュー投稿内の２つ目
            this.urlFree = ""               //自由投稿
            this.urlReview = ""             //レビュー投稿
            // 画像サイズ制限用
            this.imgRuleFree = false        //自由投稿
            this.imgRuleReview = false      //レビュー投稿
            // 音声サイズ制限用
            this.audioRuleFree = false      //自由投稿
            this.audioRuleReview1 = false   //レビュー投稿の１つ目
            this.audioRuleReview2 = false   //レビュー投稿の２つ目

            this.dialog = false
            this.tab = null
            this.free = {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio: null,
                // 画像
                image: null,
                equips: [
                    { index: 0, equip: "" },
                ],
            },
                this.review = {
                    // タイトル
                    product: "",
                    // 概要
                    overview: "",
                    // 録音情報
                    recordingMethod: "",
                    // 音声情報
                    audio1: null,
                    audio2: null,
                    // 画像
                    image: null,
                    equips: [
                        { index: 0, equip: "" },
                    ],
                }
            //機材追加数計測カウンター
            this.equipsReviewCounter = 0;
            this.equipsFreeCounter = 0
        },
    },
}
</script>

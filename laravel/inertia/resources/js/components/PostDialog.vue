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
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="free.title" required :rules="[rules.required]">
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input  prepend-icon="" prepend-inner-icon="$camera"  ref="previewFree"
                                            hint="(5MBまで)" @change="fileSelect2" v-on:change="showFree" accept=".png,.jpg" show-size v-model="free.imageName"
                                            persistent-hint :error="imgRuleFree" required :rules="[rules.required]">
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
                                            hint="(10MBまで)"  required :rules="[rules.required]" ref="playFree" show-size v-model="free.audioName"
                                            @change="fileSelect1" v-on:change="playFree" persistent-hint :error="audioRuleFree" >
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
                                        <v-textarea auto-grow v-model="free.recordingMethod" rows="2" label="録音方法"></v-textarea>
                                    </v-col>
                                    <!-- 機材 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in free.equips" v-model="free.equips[equip.index].equip"
                                            :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(equip.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="free.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- ======== 連結自由投稿 ======== -->
                                <v-row v-for="linking in linkingFree" :key="linking" :value="linking.value">
                                    <v-divider></v-divider>
                                    <!-- タイトル -->
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" v-model="linking.title"  required></v-text-field>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="音声" @change="connectAudio1"  persistent-hint required ></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow rows="1" label="概要" v-model="linking.overview"></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" label="画像" hint="(5MBまで)" @change="connectImg1"
                                            persistent-hint accept=".png , .jpg"
                                            required></v-file-input>
                                        <!-- 画像プレビュー -->
                                        <!-- 未実装 -->

                                    </v-col>
                                </v-row>
                                <!-- 連結投稿消す － -->
                                <v-card-actions class="mt-4" v-if="linkingFree.length > 0">
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$minusBoxOutline" @click="removeLinkingPost(tab)"></v-btn>
                                </v-card-actions>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postFree" v-on:click="dialog = false" :disabled="isEnterFree">
                                        投稿
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <!-- 連結投稿増やす　＋ -->
                                    <v-btn icon="$plusBoxOutline" @click="addLinkingPost(tab)"></v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- ======== レビュー投稿 ======== -->
                        <v-window-item value="review">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="review.product"  required :rules="[rules.required]">
                                            <template v-slot:label>タイトル<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera"  v-model="review.imageName"
                                            hint="(5MBまで)" persistent-hint accept=".png,.jpg" @change="fileSelect3" v-on:change="showReview"
                                            ref="previewReview" required :rules="[rules.required]" :error="imgRuleReview">
                                            <template v-slot:label>つまみの状態がわかる画像<span style="color: red"> * </span>
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
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*" v-model="review.audio1Name"
                                            persistent-hint hint="(10MBまで)"  required :rules="[rules.required]" ref="playReview1"
                                            show-size @change="fileSelect1_1" v-on:change="playReview1" :error="audioRuleReview1">
                                            <template v-slot:label>音声（エフェクターOFF）<span style="color: red"> * </span>
                                            </template>
                                        </v-file-input>
                                        <!-- 上げた音声表示１ -->
                                        <div class="playReview1-box" v-if="audioUrlReview1"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playReview1  " controls
                                                v-bind:src="audioUrlReview1"></audio>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="review.overview" rows="2" label="概要" required :rules="[rules.required]">
                                            <template v-slot:label>概要<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow v-model="review.recordingMethod" rows="2" label="録音方法" required :rules="[rules.required]">
                                            <template v-slot:label>録音方法<span style="color: red"> * </span>
                                            </template>
                                        </v-textarea>
                                        
                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="equip in review.equips"
                                        v-model="review.equips[equip.index].equip"
                                            :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'"  required :rules="[rules.required]">
                                            <template v-slot:label>機材{{ equip.index + 1 }}<span style="color: red"> * </span>
                                            </template>
                                        </v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addEquip(tab)"></v-btn>
                                        </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- ======== 連結レビュー投稿 ======== -->
                                <v-row v-for="linking in linkingReview" :key="linking" :value="linking.value">
                                    <v-divider></v-divider>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" v-model="linking.product" required></v-text-field>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*" @change="connectAudio2"
                                            hint="音声" persistent-hint required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea auto-grow rows="1" label="概要" v-model="linking.overview" ></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像" @change="connectImg2"
                                            accept=".png,.jpg" required></v-file-input>
                                        <!-- 上げた画像表示 -->
                                        <!-- 未実装 -->
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4" v-if="linkingReview.length > 0">
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$minusBoxOutline" @click="removeLinkingPost(tab)"></v-btn>
                                </v-card-actions>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="editReview" v-on:click="dialog = false" :disabled="isEnterReview">
                                        投稿
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$plusBoxOutline" @click="addLinkingPost(tab)"></v-btn>
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
            audioUrlFree:"",    //自由投稿
            audioUrlReview1:"", //レビュー投稿内の１つ目
            audioUrlReview2:"", //レビュー投稿内の２つ目
            // 画像プレビュー用
            urlFree:"",          //自由投稿
            urlReview:"",        //レビュー投稿
            // 画像サイズ制限用
            imgRuleFree: false,     //自由投稿
            imgRuleReview: false,   //レビュー投稿
            // 音声サイズ制限用
            audioRuleFree: false,     //自由投稿
            audioRuleReview1: false,   //レビュー投稿の１つ目
            audioRuleReview2: false,   //レビュー投稿の２つ目

            // 入力ルール
                        rules: {
                required: value => !!value || '必須項目です',
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
                    {index: 0, equip: ""},
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
                // 画像
                image: null,
                imageName: [],
                equips: [
                    {index: 0, equip: ""},
                ],
            },
            //連結投稿に必要な部分です。消さないで下さい。
            linkingFree: [],
            linkingReview: [],
            FreeConnect: -1,
            ReviewConnect: -1,
            connectCounter: 0,
            //機材追加数計測カウンター
            equipsReviewCounter: 0,
            equipsFreeCounter: 0,
        }
    },
    computed: {
        // 自由投稿の必須項目入力済か
        // 連結投稿未実装
        isEnterFree() {
            console.log(typeof this.linkingFree)
            console.log(this.linkingFree)
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
        // レビュー投稿の必須項目入力済か
        // 連結投稿未実装
        isEnterReview() {
            let existEquip = true
            console.log(this.review.equips.length)
            for (let i = 0; i < this.review.equips.length; i++) {
                if (this.review.equips[i].equip !== '') {
                    existEquip = true
                }
            }

            if (
                this.review.product?.trim()
                && this.review.overview?.trim()
                && this.review.recordingMethod?.trim()
                && this.review.audio1Name.length
                && this.review.imageName.length
                && existEquip
            ) {
                return false
            } else {
                return true
            }
        }
    },
    methods: {
        openPost() {
            this.dialog = true
        },
        // 使用機材追加
        addEquip(type) {
            if (type === 'free') {
                let newIndex = this.free.equips.length
                let newequip = {index: newIndex, equip: ''}
                this.free.equips.push(newequip)
            } else if (type === 'review') {
                let newIndex = this.review.equips.length
                let newequip = {index: newIndex, equip: ''}
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
        // 連結投稿追加
        addLinkingPost(type) {
            if (type === 'free') {
                let newLinkingPost = {title: "", overview: "", Audio: null, Img: null}
                this.linkingFree.push(newLinkingPost)
                this.FreeConnect++;
                console.log(this.FreeConnect);
            } else if (type === 'review') {
                let newLinkingPost = {product: "", overview: "", Audio: null, Img: null}
                this.linkingReview.push(newLinkingPost)
                this.ReviewConnect++;
                console.log(this.ReviewConnect);
            }
        },
        // 連結投稿削除
        removeLinkingPost(type) {
            if (type === 'free') {
                this.linkingFree.pop()
                this.FreeConnect -= 1;
                console.log(this.FreeConnect);
            } else if (type === 'review') {
                this.linkingReview.pop()
                this.ReviewConnect -= 1;
                console.log(this.ReviewConnect);
            }
        },

        //音声ファイル選択時の処理
        fileSelect1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.free.audio = e.target.files[0];
        },
        // 画像ファイル選択時の処理
        fileSelect2: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.free.image = e.target.files[0];
        },
        // 画像ファイル選択時の処理
        fileSelect3: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.review.image = e.target.files[0];
        },

        //音声ファイル1選択時の処理
        fileSelect1_1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.review.audio1 = e.target.files[0];
        },


/*＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝連結投稿：ファイルデータ保存処理部分＝＝＝＝＝＝＝＝＝＝＝＝＝＝
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝※決して消さないで下さい＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝*/
        //自由投稿
        connectAudio1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.linkingFree[this.FreeConnect].Audio = e.target.files[0];
            console.log(this.linkingFree);
        },
        //自由投稿
        connectImg1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.linkingFree[this.FreeConnect].Img = e.target.files[0];
            console.log(this.linkingFree);
        },
        //レビュー投稿
        connectAudio2: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.linkingReview[this.ReviewConnect].Audio = e.target.files[0];
            console.log(this.linkingReview);
        },
        //レビュー投稿
        connectImg2: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.linkingReview[this.ReviewConnect].Img = e.target.files[0];
            console.log(this.linkingReview);
        },
// ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

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
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝連結投稿データをformDataに追加する処理＝＝＝＝＝＝＝＝＝＝＝＝＝
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝絶対に消さないで下さい＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
            //連結投稿データ：整形処理
            Object.entries(this.linkingFree).forEach(([key, value]) => {
                //デバッグ
                console.log(key);
                console.log(value);
                //連結投稿データ追加
                formData.append('connectFree' + key + '_1', value.title)
                formData.append('connectFree' + key + '_2', value.overview)
                formData.append('connectFree' + key + '_3', value.Audio)
                formData.append('connectFree' + key + '_4', value.Img)
                //連結する数を集計
                this.connectCounter++;
            });
            //連結数を格納
            formData.append('connectCounter', this.connectCounter);
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let successFlg = false
            await axios.post('/api/postFree', formData, config)
                .then(function(response) {
                    console.log('成功')
                    successFlg = true
                })
                .catch(function(error) {
                    console.log('失敗')
                    console.log(error)
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
            formData.append('img', this.review.image);
            let i = 0;
            for (i = 0; i < this.review.equips.length; i++) {
                console.log(i);
                formData.append('equip' + i, this.review.equips[i]["equip"]);
                //機材追加数計測カウンター
                this.equipsReviewCounter++;
            }
            console.log(this.equipsReviewCounter);
            //機材数を格納
            formData.append('equipsCounter', this.equipsReviewCounter);
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝連結投稿データをformDataに追加する処理＝＝＝＝＝＝＝＝＝＝＝＝＝
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝絶対に消さないで下さい＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
            //連結投稿データ：整形処理
            Object.entries(this.linkingReview).forEach(([key, value]) => {
                //デバッグ
                console.log(key);
                console.log(value);
                //連結投稿データ追加
                formData.append('connectReview' + key + '_1', value.product)
                formData.append('connectReview' + key + '_2', value.overview)
                formData.append('connectReview' + key + '_3', value.Audio)
                formData.append('connectReview' + key + '_4', value.Img)
                //連結する数を集計
                this.connectCounter++;
            });
            //連結数を格納
            formData.append('connectCounter', this.connectCounter);
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let successFlg = false
            await axios.post('/api/postReview', formData, config)
                .then(function(response) {
                    console.log('成功')
                    successFlg = true
                })
                .catch(function(error) {
                    console.log('失敗')
                    console.log(error)
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
            }else{
                this.imgRuleFree = false
            }
        },

        // 連結自由投稿
        // 未実装

        // レビュー投稿
        showReview() {
            const fileReview = this.$refs.previewReview.files[0];
            this.urlReview = URL.createObjectURL(fileReview);
            //上限サイズは5MB
            if (fileReview.size > 5000000) {
                this.imgRuleReview = true
            }else{
                this.imgRuleReview = false
            }
        },

        // 連結レビュー投稿
        // 未実装

        // === 音声ファイルプレビュー === //
        // 自由投稿
        playFree() {
            const fileAudioFree = this.$refs.playFree.files[0];
            this.audioUrlFree = URL.createObjectURL(fileAudioFree);
            //上限サイズは10MB
            if (fileAudioFree.size > 10000000) {
                this.audioRuleFree = true
            }else{
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
            }else{
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
            }else{
                this.audioRuleReview2 = false
            }
        },

        // 投稿ダイアログ初期化
        initialization(){
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
                    {index: 0, equip: ""},
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
                // 画像
                image: null,
                equips: [
                    {index: 0, equip: ""},
                ],
            }
            this.linkingFree = []
            this.linkingReview = []
            this.FreeConnect = -1
            this.ReviewConnect = -1
            this.connectCounter = 0
            //機材追加数計測カウンター
            this.equipsReviewCounter = 0;
            this.equipsFreeCounter = 0
        },
    },
}
</script>

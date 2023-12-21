<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">

            <v-card>
                <v-card-actions>
                    <!-- 閉じる✕ボタン -->
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    投稿編集
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                            <!-- 製品名 -->
                            <v-col cols="12" class="pb-0">
                                <v-text-field v-model="review.title" required :rules="[rules.required]">
                                    <template v-slot:label>タイトル<span style="color: red"> * </span></template>
                                </v-text-field>
                            </v-col>
                            <!-- 画像 -->
                            <v-col cols="6" class="py-0" width="300">
                                <!-- 画像選択 -->
                                <v-file-input  prepend-icon="" prepend-inner-icon="$camera"  ref="previewReview"
                                    hint="(5MBまで)" @change="fileSelect2" v-on:change="showReview" accept=".png,.jpg" show-size v-model="review.imageName"
                                    persistent-hint :error="imgRuleReview" required :rules="[rules.required]">
                                    <template v-slot:label>画像<span style="color: red"> * </span></template>
                                </v-file-input>
                                <!-- 上げた画像表示 -->
                                <div class="previewReview-box" style="margin-bottom: 22px" v-if="urlReview">
                                    <!-- || 初期値はデータベースから持ってきた画像を表示してファイル選択されたらifで切り替える || -->
                                    <!-- 選択前 -->
                                        <!-- データベースから投稿の現在の画像を表示 -->
                                    <!-- 選択後 -->
                                    <v-img class="image-previewReview mx-auto" v-bind:src="urlReview" max-width="300"
                                        min-width="300" max-height="220" min-height="220"></v-img>
                                </div>
                            </v-col>
                            <!-- 音声 -->
                            <v-col cols="6" class="py-0" width="300">
                                <!-- 音声ファイル１ -->
                                <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*" v-model="audio1Name"
                                persistent-hint hint="(10MBまで)"  required :rules="[rules.required]" ref="playReview1"
                                show-size @change="fileSelect1_1" v-on:change="playReview1" :error="audioRuleReview1">
                                    <template v-slot:label>音声（エフェクターOFF）<span style="color: red"> * </span></template>
                                </v-file-input>
                                
                                <!-- 上げた音声表示１ -->
                                <div class="playReview1-box" v-if="audioUrlReview1" style="margin-bottom: 22px; height: 54px; ">
                                    <!-- 選択前 -->
                                        <!-- データベースから投稿の現在の音声を表示 -->
                                    <!-- 選択後 -->
                                    <audio controlslist="nodownload" class="audio-playReview1  " controls v-bind:src="audioUrlReview1"></audio>
                                </div>
                            </v-col>
                            <!-- 概要 -->
                            <v-col cols="6" class="py-0">
                                <v-textarea auto-grow v-model="review.overview" rows="2" label="概要" required :rules="[rules.required]">
                                    <template v-slot:label>概要<span style="color: red"> * </span></template>
                                </v-textarea>
                            </v-col>
                            <!-- 録音方法 --> 
                            <v-col cols="6" class="py-0">
                                <v-textarea auto-grow v-model="review.recordingMethod" rows="2" label="録音方法" required :rules="[rules.required]">
                                    <template v-slot:label>音声（エフェクターON）<span style="color: red"> * </span></template>
                                </v-textarea>
                            </v-col>
                            <!-- 機材 -->
                            <v-col cols="6" class="pt-0">
                                <v-text-field v-for="equip in review.equips" v-model="review.equips[equip.index].equip" required :rules="[rules.required]"
                                :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(equip.index + 1)">
                                    <template v-slot:label>音声（エフェクターON）<span style="color: red"> * </span></template>
                                </v-text-field>
                                <v-btn variant="flat" icon="$plus" @click="addEquip(tab)"></v-btn>
                            </v-col>
                            <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                <v-btn v-if="review.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)"></v-btn>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="editPost">
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
    data() {
        return {
            // 音声プレビュー用１
                // 選択前はデータベースから引っ張ってこないといけない //
            audioUrlReview1:"src/assets/maou_bgm_piano40.mp3",  
            // 音声プレビュー用２
                // 選択前はデータベースから引っ張ってこないといけない //
            audioUrlReview2:"src/assets/maou_bgm_acoustic54.mp3",  
            // 画像プレビュー用
                // 選択前はデータベースから引っ張ってこないといけない //
            urlReview:"src/assets/ms50g.png",          
            // 画像サイズ制限用
            imgRuleReview: false,     
            // 音声サイズ制限用
            audioRuleReview: false,   
            
            // 入力ルール
            rules: {
                required: value => !!value || '必須項目です',
            },

            snackbar: false,
            snackbarMessage: '',
            dialog: false,
            tab: null,
            review: {
                // 製品名
                title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
                // 概要
                overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はファズを使ってみました。今回使用したファズは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
                // 録音情報
                recordingMethod: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                // 音声情報
                audio1: null,
                audio1Name: [],
                // 画像
                image: null,
                imageName: [
                    {name: "ms50g.png"}
                ],
                equips: [
                    {index: 0, equip: "YAMAHA REVSTAR420"},
                    {index: 1, equip: "CANARE シールド"},
                    {index: 2, equip: "BOSS MS-50g"},
                ],
            },
            //機材追加数計測カウンター
            equipsReviewCounter: 0,
        }
    },
    props: {
        post: Object,
    },
    computed: {
        // レビュー投稿の必須項目入力済か
        // 連結投稿未実装
        isEnterReview() {
            console.log(typeof this.linkingReview)
            console.log(this.linkingReview)
            if (
                this.review.title?.trim()
                && this.review.audioName.length
                && this.review.imageName.length
            ) {
                return false
            } else {
                return true
            }
        },
    },
    methods: {
        openDialog(){
            this.dialog = true
        },

        // 使用機材追加
        addEquip(type) {
                let newIndex = this.review.equips.length
                let newequip = {index: newIndex, equip: ''}
                this.review.equips.push(newequip)
        },
        // 使用機材削除
        removeEquip(type) {
                this.review.equips.pop()
        },

        // === 画像ファイルプレビュー === //
        // レビュー投稿
        showReview() {
            const fileReview = this.$refs.previewReview.files[0];
            this.urlReview = URL.createObjectURL(fileReview);
            //上限サイズは5MB
            if (fileReview.size > 5000000) {
                // エラー表示
                this.imgRuleReview = true
            }else{
                this.imgRuleReview = false
            }
        },

        // === 音声ファイルプレビュー === //
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

        // 投稿編集保存
        editPost(){
            this.dialog = false
            // 編集内容を適応する処理を書く
        },

        // 投稿ダイアログ初期化
        initialization(){
            this.audioUrlReview = ""          
            this.urlReview = ""               
            // 画像サイズ制限用
            this.imgRuleReview = false        
            // 音声サイズ制限用
            this.audioRuleReview = false      

            this.dialog = false
            this.tab = null
            this.review = {
                // 製品名
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
            }
        },
    },
}

</script>

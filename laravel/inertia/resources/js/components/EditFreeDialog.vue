<template>
    <!-- {{ free.imageName[0].name }} -->
    <v-btn @click="test">test</v-btn>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
            <!-- テスト用ボタン -->
            <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
            </template>
            <!--  -->

            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    投稿編集
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                                    <!-- タイトル -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="free.title" label="タイトル" required></v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" ref="previewFree"
                                            label="画像" hint="(5MBまで)" @change="fileSelect2" v-on:change="showFree" accept=".png,.jpg" show-size v-model="free.imageName"
                                            persistent-hint :error="imgRuleFree"></v-file-input>
                                        <!-- 上げた画像表示 -->
                                        <div class="previewFree-box" style="margin-bottom: 22px" v-if="urlFree">
                                            <!-- || 初期値はデータベースから持ってきた画像を表示してファイル選択されたらifで切り替える || -->
                                            <!-- 選択前 -->
                                                <!-- データベースから投稿の現在の画像を表示 -->
                                            <!-- 選択後 -->
                                            <v-img class="image-previewFree mx-auto" v-bind:src="urlFree" max-width="300"
                                                min-width="300" max-height="220" min-height="220"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!--　音声ファイル選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="(10MBまで)" label="音声" required ref="playFree" show-size v-model="free.audioName"
                                            @change="fileSelect1" v-on:change="playFree" persistent-hint :error="audioRuleFree"></v-file-input>
                                        <!-- 上げた音声表示 -->
                                        <div class="playFree-box" v-if="audioUrlFree" style="margin-bottom: 22px; height: 54px; ">
                                            <!-- 選択前 -->
                                                <!-- データベースから投稿の現在の音声を表示 -->
                                            <!-- 選択後 -->
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

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary">
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
            // 音声プレビュー用
                // 選択前はデータベースから引っ張ってこないといけない //
            audioUrlFree:"src/assets/maou_bgm_acoustic54.mp3",  
            // 画像プレビュー用
                // 選択前はデータベースから引っ張ってこないといけない //
            urlFree:"src/assets/ms50g.png",          
            // 画像サイズ制限用
            imgRuleFree: false,     
            // 音声サイズ制限用
            audioRuleFree: false,     

            snackbar: false,
            snackbarMessage: '',
            dialog: false,
            tab: null,
            free: {
                // タイトル
                title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
                // 概要
                overview: "今回はBOSSのMS-50gのレビューをしてみました。１００種のエフェクトから最大６種類組み合わせることができるのですが、今回私はファズを使ってみました。今回使用したファズは、「TB MK1.5」というファズです。追加エフェクトなのでPCとつないで追加する必要があります。「ZNR」というノイズリダクションも追加します。",
                // 録音情報
                recordingMethod: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                // 音声情報
                audio: null,
                audioName: [ 
                    {name: "maou_bgm_piano40.mp3"},
                ],
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
    },
    methods: {
        // 使用機材追加
        addEquip(type) {
                let newIndex = this.free.equips.length
                let newequip = {index: newIndex, equip: ''}
                this.free.equips.push(newequip)
        },
        // 使用機材削除
        removeEquip(type) {
                this.free.equips.pop()
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

        // 投稿ダイアログ初期化
        initialization(){
            this.audioUrlFree = ""          
            this.urlFree = ""               
            // 画像サイズ制限用
            this.imgRuleFree = false        
            // 音声サイズ制限用
            this.audioRuleFree = false      

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
            }
        },
    }
}

</script>

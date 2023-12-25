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
                            <!-- タイトル -->
                            <v-col cols="12" class="pb-0">
                                <v-text-field v-model="_post.title" required :rules="[rules.required]">
                                    <template v-slot:label>タイトル<span style="color: red"> * </span></template>
                                </v-text-field>
                            </v-col>
                            <!-- 画像 -->
                            <v-col cols="6" class="py-0" width="300">
                                <!-- 画像選択 -->
                                <v-file-input  prepend-icon="" prepend-inner-icon="$camera"  ref="previewFree"
                                    hint="(5MBまで)" v-on:change="showFree" accept=".png,.jpg" show-size v-model="_post.image"
                                    persistent-hint :error="imgRuleFree" required :rules="[rules.required]">
                                    <template v-slot:label>画像<span style="color: red"> * </span></template>
                                </v-file-input>
                            </v-col>
                            <!-- 音声 -->
                            <v-col cols="6" class="py-0" width="300">
                                <!--　音声ファイル選択 -->
                                <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                    hint="(10MBまで)"  required :rules="[rules.required]" ref="playFree" show-size v-model="_post.audio"
                                    v-on:change="playFree" persistent-hint :error="audioRuleFree" >
                                    <template v-slot:label>音声<span style="color: red"> * </span></template>
                                </v-file-input>
                            </v-col>
                            <!-- 概要 -->
                            <v-col cols="6" class="py-0">
                                <v-textarea auto-grow v-model="_post.overview" rows="2" label="概要"></v-textarea>
                            </v-col>
                            <!-- 録音方法 -->
                            <v-col cols="6" class="py-0">
                                <v-textarea auto-grow v-model="_post.recordingMethod" rows="2" label="録音方法"></v-textarea>
                            </v-col>
                            <!-- 機材 -->
                            <v-col cols="6" class="pt-0">
                                <v-text-field v-for="equip in _post.equips" v-model="_post.equips[equip.index].equip"
                                    :hint="'楽器から' + String(equip.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(equip.index + 1)"></v-text-field>
                                <v-btn variant="flat" icon="$plus" @click="addEquip(tab)"></v-btn>
                            </v-col>
                            <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                <v-btn v-if="_post.equips.length > 1" variant="flat" icon="$minus" @click="removeEquip(tab)"></v-btn>
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
    <div v-for="item, key in post">
        {{ key }}
        {{ item }}
        <br>
    </div>
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
            
            // 入力ルール
            rules: {
                required: value => !!value || '必須項目です',
            },

            snackbar: false,
            snackbarMessage: '',
            dialog: false,
            tab: null,
            setDialog: false,
            //機材追加数計測カウンター
            equipsFreeCounter: 0,
            _post: {
                // タイトル
                title: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                audio: null,
                audioName: [ 
                    {name: ""},
                ],
                // 画像
                image: null,
                imageName: [
                    {name: ""}
                ],
                equips: [],
            },
        }
    },
    props: {
        post: Object,
    },
    computed: {
        // 自由投稿の必須項目入力済か
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
        openDialog(){
            if (!this.setDialog) {
                this._post.title = this.post.TITLE
                this._post.overview = this.post.OVERVIEW
                this._post.recordingMethod = this.post.RECORDING_METHOD
                this._post.audioName = this.post.AUDIO1
                this._post.imageName = this.post.IMAGES
                for (let i = 0; i < this.post.ITEMS.length; i++) {
                    let equip = {index: i, equip: this.post.ITEMS[i]}
                    this._post.equips.push(equip)
                }
                this.setDialog = true
            }
            this.dialog = true
        },

        // 使用機材追加
        addEquip(type) {
                let newIndex = this._post.equips.length
                let newequip = {index: newIndex, equip: ''}
                this._post.equips.push(newequip)
        },
        // 使用機材削除
        removeEquip(type) {
                this._post.equips.pop()
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

        // 投稿編集保存
        editPost(){
            this.dialog = false
            // 編集内容を適応する処理を書く
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
    },
}

</script>

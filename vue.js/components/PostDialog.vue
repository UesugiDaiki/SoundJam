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
                                        <v-text-field v-model="free.product" label="タイトル" required></v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" ref="previewFree"
                                            label="画像" hint="(5MBまで)" v-on:change="showFree" accept=".png,.jpg" show-size
                                            persistent-hint :error="imgRuleFree"></v-file-input>
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
                                            hint="(10MBまで)" label="音声" required ref="playFree" show-size
                                            v-on:change="playFree" persistent-hint :error="audioRuleFree"></v-file-input>
                                        <!-- 上げた音声表示 -->
                                        <div class="playFree-box" v-if="audioUrlFree"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playFree " controls
                                                v-bind:src="audioUrlFree"></audio>
                                        </div>
                                    </v-col>
                                    <!-- 概要 -->
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="free.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 録音方法 -->
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="free.recordingMethod" rows="2" label="録音方法"></v-textarea>
                                    </v-col>
                                    <!-- 機材 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in free.products"
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'"
                                            :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="free.products.length > 1" variant="flat" icon="$minus"
                                            @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- ======== 連結自由投稿 ======== -->
                                <v-row v-for="linking in linkingFree">
                                    <v-divider></v-divider>
                                    <!-- タイトル -->
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" required></v-text-field>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="音声" persistent-hint required ></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" label="画像" hint="(5MBまで)"
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
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
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
                                    <!-- 製品名 -->
                                    <v-col cols="12" class="pb-0">
                                        <v-text-field v-model="review.product" label="製品名" required></v-text-field>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" label="つまみの状態がわかる画像"
                                            hint="(5MBまで)" persistent-hint accept=".png,.jpg" v-on:change="showReview"
                                            ref="previewReview" required :error="imgRuleReview"></v-file-input>
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
                                            persistent-hint hint="(10MBまで)" label="音声（エフェクターOFF）" required ref="playReview1"
                                            show-size v-on:change="playReview1" :error="audioRuleReview1"></v-file-input>
                                        <!-- 上げた音声表示１ -->
                                        <div class="playReview1-box" v-if="audioUrlReview1"
                                            style="margin-bottom: 22px; height: 54px; ">
                                            <audio controlslist="nodownload" class="audio-playReview1  " controls
                                                v-bind:src="audioUrlReview1"></audio>
                                        </div>
                                        <!-- 音声ファイル２ -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            persistent-hint hint="(10MBまで)" label="音声（エフェクターON）" required ref="playReview2"
                                            show-size v-on:change="playReview2" :error="audioRuleReview2"></v-file-input>
                                        <!-- 上げた音声表示２ -->
                                        <div class="playReview2-box" v-if="audioUrlReview2"
                                            style="margin-bottom: 22px; height: 54px;">
                                            <audio controlslist="nodownload" class="audio-playReview2 " controls
                                                v-bind:src="audioUrlReview2"></audio>
                                        </div>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="review.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="review.recordingMethod" rows="2" label="録音方法"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in review.products"
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'"
                                            :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.products.length > 1" variant="flat" icon="$minus"
                                            @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- ======== 連結レビュー投稿 ======== -->
                                <v-row v-for="linking in linkingReview">
                                    <v-divider></v-divider>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" required></v-text-field>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="音声" persistent-hint required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
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
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
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

            dialog: false,
            tab: null,
            free: {
                title: "",
                overview: "",
                recordingMethod: "",
                products: [
                    {index: 0, product: ""},
                ],
            },
            review: {
                product: "",
                overview: "",
                recordingMethod: "",
                products: [
                    {index: 0, product: ""},
                ],
            },
            linkingFree: [],
            linkingReview: [],

        }
    },
    methods: {
        openPost() {
            this.dialog = true
        },
        // 使用機材追加
        addProduct(type) {
            if (type === 'free') {
                let newIndex = this.free.products.length
                let newProduct = {index: newIndex, product: ''}
                this.free.products.push(newProduct)
            } else if (type === 'review') {
                let newIndex = this.review.products.length
                let newProduct = {index: newIndex, product: ''}
                this.review.products.push(newProduct)
            }
        },
        // 使用機材削除
        removeProduct(type) {
            if (type === 'free') {
                this.free.products.pop()
            } else if (type === 'review') {
                this.review.products.pop()
            }
        },
        // 連結投稿追加
        addLinkingPost(type) {
            if (type === 'free') {
                let newLinkingPost = {title: "", overview: ""}
                this.linkingFree.push(newLinkingPost)
            } else if (type === 'review') {
                let newLinkingPost = {product: "", overview: ""}
                this.linkingReview.push(newLinkingPost)
            }
        },
        // 連結投稿削除
        removeLinkingPost(type) {
            if (type === 'free') {
                this.linkingFree.pop()
            } else if (type === 'review') {
                this.linkingReview.pop()
            }
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

        // 閉じる際に初期化
        initialization(){
            //投稿の画像のプレビュー用
            this.urlFree = "" 
            // this.urlLinkingFree = "" 
            this.urlReview = "" 
            // this.urlLinkingReview = ""
            //投稿の音声プレビュー用
            this.audioUrlFree = "" 
            this.audioUrlReview1 = "" 
            this.audioUrlReview2 = "" 
        },

    }
}


</script>
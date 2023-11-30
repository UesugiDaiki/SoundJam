<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640" height="515">
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
                                            v-on:change="showFree" accept="image/*" 
                                            show-size></v-file-input>
                                        <!-- 上げた画像表示 -->
                                        <div class="previewFree-box" style="margin-bottom: 22px" v-if="urlFree">
                                            <v-img class="image-previewFree mx-auto" v-bind:src="urlFree" max-width="250"
                                                min-width="250" max-height="190" min-height="190"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!--　音声ファイル選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                        hint="音声" required ref="playFree" show-size v-on:change="playFree"></v-file-input>
                                        <!-- 上げた音声表示 -->
                                        <div class="playFree-box" v-if="audioUrlFree">
                                                <audio controlslist="nodownload" class="audio-playFree audio-position-free" controls
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
                                            hint="音声" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            accept="image/*" ref="preview" v-on:change="showLinkingFree"
                                            required></v-file-input>
                                        <!-- 画像プレビュー -->
                                        <div class="preview-box" v-if="urlLinkingFree">
                                            <v-img class="image-preview" v-bind:src="urlLinkingFree" max-width="250"
                                                min-width="250" max-height="190" min-height="190"></v-img>
                                        </div>
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
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            accept="image/*" v-on:change="showReview"  ref="previewReview" required></v-file-input>
                                        <!-- 画像プレビュー -->
                                        <div class="previewReview-box" v-if="urlReview">
                                            <v-img class="image-previewReview" v-bind:src="urlReview" max-width="250"
                                                min-width="250" max-height="190" min-height="190"></v-img>
                                        </div>
                                    </v-col>
                                    <!-- 音声 -->
                                    <v-col cols="6" class="py-0" width="300">
                                        <!-- 音声ファイル１ -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="音声（エフェクターOFF）" required ref="playReview1" show-size v-on:change="playReview1"></v-file-input>
                                            <!-- 上げた音声表示１ -->
                                            <div class="playReview1-box" v-if="audioUrlReview1">
                                                <audio controlslist="nodownload" class="audio-playReview1 audio-position-free" controls
                                                v-bind:src="audioUrlReview1"></audio>
                                            </div>
                                        <!-- 音声ファイル２ -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" accept="audio/*"
                                            hint="音声（エフェクターON）" required ref="playReview2" show-size v-on:change="playReview2"></v-file-input>
                                            <!-- 上げた音声表示２ -->
                                            <div class="playReview2-box" v-if="audioUrlReview2">
                                                <audio controlslist="nodownload" class="audio-playReview2 audio-position-free" controls
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
                                            hint="音声" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <!-- 画像 -->
                                    <v-col cols="6" class="py-0">
                                        <!-- 画像選択 -->
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            accept="image/*"  required></v-file-input>
                                        <!-- 上げた画像表示 -->
                                        <!-- 未実装 -->
                                        <!-- <div class="preview-box" v-if="urlLinkingReview">
                                            <v-img class="image-preview" v-bind:src="urlLinkingReview" max-width="250"
                                                min-width="250" max-height="190" min-height="190"></v-img>
                                        </div> -->
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
            // urlLinkingFree:"",   //連結自由投稿
            urlReview:"",        //レビュー投稿
            // urlLinkingReview:"", //連結レビュー投稿
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
            Files: "",
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
        },
        // 連結自由投稿 
        // 未実装
        // showLinkingFree() {
        //     const file = this.$refs.preview.files[0];
        //     this.urlLinkingFree = URL.createObjectURL(file);
        // },
        // レビュー投稿 
        showReview() {
            const fileReview = this.$refs.previewReview.files[0];
            this.urlReview = URL.createObjectURL(fileReview);
        },
        // 連結レビュー投稿 
        // 未実装
        // showLinkingReview() {
        //     const file = this.$refs.preview.files[0];
        //     this.urlLinkingReview = URL.createObjectURL(file);
        // },

        // === 音声ファイルプレビュー === //
        // 自由投稿
        playFree() {
            const file = this.$refs.playFree.files[0];
            this.audioUrlFree = URL.createObjectURL(file);
        },
        // レビュー投稿１
        playReview1() {
            const file = this.$refs.playReview1.files[0];
            this.audioUrlReview1 = URL.createObjectURL(file);
        },
        // レビュー投稿２
        playReview2() {
            const file = this.$refs.playReview2.files[0];
            this.audioUrlReview2 = URL.createObjectURL(file);
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
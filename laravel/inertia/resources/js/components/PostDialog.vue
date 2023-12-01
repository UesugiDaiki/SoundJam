<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640" height="515">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title>
                    <v-tabs v-model="tab">
                        <v-tab width="50%" value="free">自由投稿</v-tab>
                        <v-tab width="50%" value="review">レビュー投稿</v-tab>
                    </v-tabs>
                </v-card-title>

                <v-card-text>
                    <v-window v-model="tab">
                        <!-- 自由投稿 -->
                        <v-window-item value="free">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field v-model="free.product" label="タイトル" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" hint="音声" @change="fileSelect1" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像" @change="fileSelect2" required></v-file-input>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="free.overview" rows="2" label="概要"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea v-model="free.recordingMethod" rows="2" label="録音方法"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in free.products"
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="free.products.length > 1" variant="flat" icon="$minus" @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- 連結投稿 -->
                                <v-row v-for="linking in linkingFree">
                                    <v-divider></v-divider>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                        hint="音声" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            required></v-file-input>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4" v-if="linkingFree.length > 0">
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$minusBoxOutline" @click="removeLinkingPost(tab)"></v-btn>
                                </v-card-actions>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postcreate" v-on:click="dialog = false">
                                        投稿
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$plusBoxOutline" @click="addLinkingPost(tab)"></v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- レビュー投稿 -->
                        <v-window-item value="review">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field v-model="review.product" label="製品名" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                        hint="音声（エフェクターOFF）" @change="fileSelect1_1" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像" @change="fileSelect2"
                                            required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                        hint="音声（エフェクターON）" @change="fileSelect1_2" required></v-file-input>
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
                                        <v-text-field v-for="product in review.products"
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.products.length > 1" variant="flat" icon="$minus" @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- 連結投稿 -->
                                <v-row v-for="linking in linkingReview">
                                    <v-divider></v-divider>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                        hint="音声" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-textarea rows="1" label="概要"></v-textarea>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            required></v-file-input>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-4" v-if="linkingReview.length > 0">
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$minusBoxOutline" @click="removeLinkingPost(tab)"></v-btn>
                                </v-card-actions>

                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="editReview" v-on:click="dialog = false">
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
            dialog: false,
            tab: null,
            free: {
                // title: "",
                // overview: "",
                // recordingMethod: "",
                // products: [
                //     {index: 0, product: ""},
                // ],
                // タイトル
                product: "",
                // 概要
                overview: "",
                // 録音情報
                recordingMethod: "",
                // 音声情報
                selected_file1: null,
                // 画像
                selected_file2: null,
                products: [
                    {index: 0, product: ""},
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
                selected_file1_1: null,
                selected_file1_2: null,
                // 画像
                selected_file2: null,
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
        //音声ファイル選択時の処理
        fileSelect1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.selected_file1 = e.target.files[0];
        },
        // 画像ファイル選択時の処理
        fileSelect2: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.selected_file2 = e.target.files[0];
        },

        //音声ファイル1選択時の処理
        fileSelect1_1: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.selected_file1_1 = e.target.files[0];
        },
        //音声ファイル2選択時の処理
        fileSelect1_2: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.selected_file1_2 = e.target.files[0];
        },

        // 投稿処理
        postcreate() {
            // 確認
            console.log(this.selected_file);
            console.log(this.free.product);
            console.log(this.free.overview);
            let formData = new FormData();
            formData.append('product',this.free.product);
            formData.append('overview',this.free.overview);
            formData.append('recordingMethod',this.free.recordingMethod);
            formData.append('mp3',this.selected_file1);
            formData.append('img',this.selected_file2);

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post('/api/postcreate', formData, config)
                .then(function(response) {
                    console.log('成功')
                })
                .catch(function(error) {
                    console.log('失敗');
                    console.log(error);
                })
        },
        // 投稿処理
        editReview() {
            // 確認
            console.log(this.selected_file);
            console.log(this.review.product);
            console.log(this.review.overview);
            let formData = new FormData();

            formData.append('product',this.review.product);
            formData.append('overview',this.review.overview);
            formData.append('recordingMethod',this.review.recordingMethod);
            formData.append('mp3_1',this.selected_file1_2);
            formData.append('mp3_2',this.selected_file1_2);
            formData.append('img',this.selected_file2);

            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post('/api/editReview', formData, config)
                .then(function(response) {
                    console.log('成功')
                })
                .catch(function(error) {
                    console.log('失敗');
                    console.log(error);
                })
        }
    }
}
</script>

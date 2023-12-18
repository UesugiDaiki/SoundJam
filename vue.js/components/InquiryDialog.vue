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
                                        <v-text-field label="件名" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea label="本文" required></v-textarea>
                                    </v-col>
                                </v-row>

                                <v-card-actions class="mt-15">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                        送信
                                    </v-btn>
                                </v-card-actions>
                            </form>
                        </v-window-item>

                        <!-- プロモーション依頼 -->
                        <v-window-item value="review">
                            <form @submit.prevent="submit">
                                <v-row>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field v-model="review.product" label="製品名" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                            hint="音声（エフェクターOFF）" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                            hint="音声（エフェクターON）" required></v-file-input>
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
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'"
                                            :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.products.length > 1" variant="flat" icon="$minus"
                                            @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>

                                <!-- 連結投稿 -->
                                <v-row v-for="linking in linkingReview">
                                    <v-divider></v-divider>
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="タイトル" required></v-text-field>
                                    </v-col>
                                    <v-col cols="6" class="pb-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" hint="音声"
                                            required></v-file-input>
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
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
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
</template>
  
<script>
export default {
    data() {
        return {
            dialog: false,
            tab: null,
            review: {
                product: "",
                overview: "",
                recordingMethod: "",
                products: [
                    { index: 0, product: "" },
                ],
            },
            linkingReview: [],
        }
    },
    methods: {
        openInquiry() {
            this.dialog = true
        },
        // 使用機材追加
        addProduct() {
            let newIndex = this.review.products.length
            let newProduct = { index: newIndex, product: '' }
            this.review.products.push(newProduct)
        },
        // 使用機材削除
        removeProduct() {
            this.review.products.pop()
        },
        // 連結投稿追加
        addLinkingPost() {
            let newLinkingPost = { product: "", overview: "" }
            this.linkingReview.push(newLinkingPost)
        },
        // 連結投稿削除
        removeLinkingPost() {
            this.linkingReview.pop()
        }
    }
}
</script>
  
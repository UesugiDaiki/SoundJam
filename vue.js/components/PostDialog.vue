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
                                        <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                        hint="音声" required></v-file-input>
                                    </v-col>
                                    <v-col cols="6" class="py-0">
                                        <v-file-input prepend-icon="" prepend-inner-icon="$camera" hint="つまみの状態がわかる画像"
                                            required></v-file-input>
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


                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                        投稿
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$plusBoxOutline"></v-btn>
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
                                            :hint="'楽器から' + String(product.index + 1) + 'つ目につなげた機材名'" :label="'機材' + String(product.index + 1)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus" @click="addProduct(tab)"></v-btn>
                                    </v-col>
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="review.products.length > 1" variant="flat" icon="$minus" @click="removeProduct(tab)"></v-btn>
                                    </v-col>
                                </v-row>


                                <v-card-actions class="mt-4">
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                        投稿
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn icon="$plusBoxOutline"></v-btn>
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
    }
}
</script>
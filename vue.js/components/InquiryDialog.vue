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
                                        <v-text-field label="Legal first name*" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea label="Legal first name*" required></v-textarea>
                                    </v-col>
                                </v-row>

                                <v-card-actions>
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
                                    <!-- 左上 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-text-field label="Legal first name*" required></v-text-field>
                                        <v-text-field label="Legal first name*" required></v-text-field>
                                        <v-textarea rows="2" label="Label"></v-textarea>
                                        <v-textarea rows="2" label="Label"></v-textarea>
                                    </v-col>
                                    <!-- 右上 -->
                                    <v-col cols="6" class="pb-0">
                                        <v-col class="pa-0" cols="12" style="height: 156px;">
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                                required></v-file-input>
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth"
                                                required></v-file-input>
                                        </v-col>
                                        <v-col class="pa-0" cols="12">
                                            <v-file-input prepend-icon="" prepend-inner-icon="$camera"
                                                required></v-file-input>
                                        </v-col>
                                    </v-col>
                                    <!-- 左下 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in reviewProducts"
                                            :label="String(product.id)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus"></v-btn>
                                    </v-col>
                                    <!-- 右下 -->
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="reviewProducts.length > 1" variant="flat" icon="$minus"></v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions>
                                    <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                        送信
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
            reviewProducts: [
                {id: 0, item: '製品名１'},
            ],  
        }
    },
    methods: {
        openInquiry() {
            this.dialog = true
        }
    }
}
</script>
  
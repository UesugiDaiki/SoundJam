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
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" required ></v-file-input>
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" required ></v-file-input>
                                        </v-col>
                                        <v-col class="pa-0" cols="12">
                                            <v-file-input prepend-icon="" prepend-inner-icon="$camera" required></v-file-input>
                                        </v-col>
                                    </v-col>
                                    <!-- 左下 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in freeProducts" :label="String(product.id)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus"></v-btn>
                                    </v-col>
                                    <!-- 右下 -->
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="freeProducts.length > 1" variant="flat" icon="$minus"></v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions>
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
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" required ></v-file-input>
                                            <v-file-input prepend-icon="" prepend-inner-icon="$musicNoteEighth" required ></v-file-input>
                                        </v-col>
                                        <v-col class="pa-0" cols="12">
                                            <v-file-input prepend-icon="" prepend-inner-icon="$camera" required></v-file-input>
                                        </v-col>
                                    </v-col>
                                    <!-- 左下 -->
                                    <v-col cols="6" class="pt-0">
                                        <v-text-field v-for="product in reviewProducts" :label="String(product.id)"></v-text-field>
                                        <v-btn variant="flat" icon="$plus"></v-btn>
                                    </v-col>
                                    <!-- 右下 -->
                                    <v-col cols="6" class="pt-0 d-flex align-end" style="padding-bottom: 86px;">
                                        <v-btn v-if="reviewProducts.length > 1" variant="flat" icon="$minus"></v-btn>
                                    </v-col>
                                </v-row>

                                <v-card-actions>
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
            freeProducts: [
                {id: 0, item: '製品名１'},
                {id: 1, item: '製品名２'}
            ],
            reviewProducts: [
                {id: 0, item: '製品名１'},
            ],
        }
    },
    methods: {
        openPost() {
            this.dialog = true
        }
    }
}
</script>
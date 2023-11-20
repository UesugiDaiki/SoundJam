<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    製品登録
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="12" class="pb-0">
                                <v-text-field label="Legal first name*" required></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field label="Legal first name*" required></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field label="Legal first name*" required></v-text-field>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                登録
                            </v-btn>
                        </v-card-actions>
                    </form>
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
                { id: 0, item: '製品名１' },
                { id: 1, item: '製品名２' }
            ],
            reviewProducts: [
                { id: 0, item: '製品名１' },
            ],
        }
    },
    methods: {
        openRegistProduct() {
            this.dialog = true
        }
    }
}
</script>
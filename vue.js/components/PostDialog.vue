<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
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
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Legal first name*" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Legal middle name"
                                            hint="example of helper text only on focus"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Legal last name*" hint="example of persistent helper text"
                                            persistent-hint required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Email*" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Password*" type="password" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-select :items="['0-17', '18-29', '30-54', '54+']" label="Age*"
                                            required></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-autocomplete
                                            :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                                            label="Interests" multiple></v-autocomplete>
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
                                <v-text-field label="Name"></v-text-field>
                                <v-text-field label="Phone Number"></v-text-field>
                                <v-text-field label="E-mail"></v-text-field>
                                <v-select label="Select"></v-select>
                                <v-checkbox label="Option" type="checkbox"></v-checkbox>
                                <v-btn class="me-4" type="submit">
                                    投稿
                                </v-btn>

                                <v-btn>
                                    clear
                                </v-btn>
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
        }
    },
    methods: {
        openPost() {
            this.dialog = true
        }
    }
}
</script>
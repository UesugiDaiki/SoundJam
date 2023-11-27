<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    プロフィール変更
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="12" class="pb-0">
                                <v-text-field label="ユーザー名" v-model="user.name" required></v-text-field>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-file-input prepend-icon="" prepend-inner-icon="$camera"></v-file-input>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-text-field prepend-inner-icon="$link" v-model="user.link" required></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-textarea label="プロフィール" rows="3" v-model="user.profile" required></v-textarea>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary">
                                保存
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
        }
    },
    props: {
        user: Object,
    },
    methods: {
        openEditProfile() {
            this.dialog = true
        }
    }
}
</script>
  
<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" width="auto">
            <v-card>
                <v-card-title class="text-center pt-5">ログアウトしますか？</v-card-title>
                <v-card-text class="px-3 py-5">
                    <v-btn color="error" class="mx-5" @click="logout"> ログアウト </v-btn>
                    <v-btn variant="tonal" class="mx-5" @click="dialog = false">
                        閉じる
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            dialog: false,
        }
    },
    methods: {
        openLogout(){
            this.dialog = true
        },
        async logout(){
            axios.get('api/logout')
            location.reload()
        }
    }
}
</script>
<template>
    <v-list-item-title class="ma-4 text-h6">通知設定</v-list-item-title>
    <v-divider></v-divider>
    <v-card rounded="0" elevation="0" class="mt-3 pb-6">
        <v-card-title class="d-flex pb-0">
            <v-sheet height="31" width="100" class="my-auto text-subtitle-1">
                フォロー通知
            </v-sheet>
            <v-spacer></v-spacer>
            <v-switch color="primary" :model-value="followNotice" label="ON" hide-details @click="changeFollowNotice"></v-switch>
        </v-card-title>
        <v-card-subtitle>
            他のユーザーからフォローされた際に通知します
        </v-card-subtitle>
    </v-card>
    <v-divider></v-divider>
    <v-card rounded="0" elevation="0" class="mt-3 pb-6">
        <v-card-title class="d-flex pb-0">
            <v-sheet height="31" width="100" class="my-auto text-subtitle-1">
                いいね通知
            </v-sheet>
            <v-spacer></v-spacer>
            <v-switch color="primary" :model-value="likeNotice" label="ON" hide-details @click="changeLikeNotice"></v-switch>
        </v-card-title>
        <v-card-subtitle>
            (仮テキスト)他のユーザーからいいねされた際に通知します
        </v-card-subtitle>
    </v-card>
</template>

<script>
import axios from 'axios';

export default {
    created() {
        this.getNoticeSettings()
    },
    data: () => ({
        settings: [],
    }),
    computed: {
        followNotice() {
            return this.settings["FOLLOW_NOTICE"] === 1
        },
        likeNotice() {
            return this.settings["LIKE_NOTICE"] === 1
        }
    },
    methods: {
        async getNoticeSettings() {
            let _settings = await axios.get("/api/getNoticeSettings")
            this.settings = _settings.data[0]
        },
        changeFollowNotice() {
            if (this.followNotice) {
                this.settings["FOLLOW_NOTICE"] = 0
                axios.get("/api/offFollowNotice")
            } else {
                this.settings["FOLLOW_NOTICE"] = 1
                axios.get("/api/onFollowNotice")
            }
        },
        changeLikeNotice() {
            if (this.likeNotice) {
                this.settings["LIKE_NOTICE"] = 0
                axios.get("/api/offLikeNotice")
            } else {
                this.settings["LIKE_NOTICE"] = 1
                axios.get("/api/onLikeNotice")
            }
        }
    },
}
</script>

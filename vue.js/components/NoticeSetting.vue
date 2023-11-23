<template>
    <v-list-item-title class="ma-4 text-h6">通知設定</v-list-item-title>
    <v-divider></v-divider>
    <v-card rounded="0" elevation="0" class="mt-3 pb-6">
        <v-card-title class="d-flex pb-0">
            <v-sheet height="31" width="100" class="my-auto text-subtitle-1">
                フォロー通知
            </v-sheet>
            <v-spacer></v-spacer>
            <v-switch color="primary" :model-value="true" label="ON" hide-details></v-switch>
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
            <v-switch color="primary" :model-value="true" label="ON" hide-details class=""></v-switch>
        </v-card-title>
        <v-card-subtitle>
            (仮テキスト)他のユーザーからいいねされた際に通知します
        </v-card-subtitle>
    </v-card>
</template>

<script>
export default {
    data: () => ({
        loginDialog: false,
    }),
}
</script>

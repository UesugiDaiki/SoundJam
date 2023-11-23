<template>
    <v-list-item-title> <span class="mx-4 mt-5 text-h5">通知設定</span> </v-list-item-title>
    <v-divider></v-divider>
    <v-card rounded="0" elevation="0" class="mt-3 pb-6">
        <v-card-title class="d-flex pb-0">
            <v-sheet height="31" width="100" class="my-auto">
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
            <v-sheet height="31" width="100" class="my-auto">
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

<template>
    <v-card width="570px" rounded="0" elevation="0" style="border: 1px solid #ddd;">
        <!-- アイコン、ユーザー名 -->
        <v-card-title class="d-flex">
            <v-avatar image="src/assets/masaya.png" size="150"></v-avatar>
            <v-card-title class="my-auto text-h5 font-weight-bold">雅弥</v-card-title>
            <v-spacer></v-spacer>
            <!-- ログイン済アカウント -->
            <v-btn class="my-auto mx-1" v-if="loggedInAccount" icon="$cogOutline" elevation="0"></v-btn>
            <!-- 他アカウント -->
            <v-btn class="my-auto mx-1" v-if="!loggedInAccount" color="primary" elevation="0" rounded height="48">フォロー</v-btn>
            <v-btn class="my-auto mx-1" v-if="!loggedInAccount" icon="$bellOutline" elevation="0"></v-btn>
        </v-card-title>
    </v-card>
</template>

<script>
export default {
    data: () => ({
        loggedInAccount: true,
    })
}
</script>
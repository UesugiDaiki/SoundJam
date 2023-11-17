<template>
    <v-row class="pl-3" justify="center">
        <v-card width="570px" rounded="0" elevation="0" style="border: 1px solid #ddd;">
            <!-- アイコン、ユーザー名 -->
            <v-card-title class="d-flex">
                <v-avatar image="src/assets/masaya.png" size="150"></v-avatar>
                <v-card-title class="my-auto text-h5 font-weight-bold">{{ user.name }}</v-card-title>
                <v-spacer></v-spacer>
                <!-- ログイン済アカウント -->
                <v-btn class="my-auto mx-1" v-if="loggedInAccount" icon="$cogOutline" elevation="0"></v-btn>
                <!-- end -->

                <!-- 他アカウント -->
                <v-btn class="my-auto mx-1" v-if="!loggedInAccount" color="primary" elevation="0" rounded
                    height="48">フォロー</v-btn>
                <v-btn class="my-auto mx-1" v-if="!loggedInAccount" icon="$bellOutline" elevation="0"></v-btn>
                <!-- end -->
            </v-card-title>
            <v-sheet class="ma-3">
                <v-sheet style="color: #666"><v-icon class="mx-2">$at</v-icon>{{ user.id }}</v-sheet>
                <v-sheet style="color: #666"><v-icon class="mx-2">$link</v-icon>{{ user.link }}</v-sheet>
            </v-sheet>
            <v-card rounded="0" elevation="0">
                <v-card-text style="color: #666">
                    {{ user.profile }}
                </v-card-text>
            </v-card>
        </v-card>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        loggedInAccount: true,
    }),
    props: {
        user: Object,
    }
}
</script>
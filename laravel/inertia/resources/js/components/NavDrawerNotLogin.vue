<template>
    <v-container>
        <v-navigation-drawer permanent>
            <v-list nav>
                <v-list-item to="/home" :ripple="false" :active="false" class="text-h6 font-weight-black text-center ml-auto">SoundJam</v-list-item>
                <v-list-item to="/home" :ripple="false" :active="false" class="text-center pa-2 ml-auto"><v-icon class="text-h4 text-right">{{
                    path === "/home" ? "$home" : "$homeOutline" }}</v-icon></v-list-item>
                <v-list-item to="/search" :ripple="false" :active="false" class="text-center pa-2 ml-auto"><v-icon
                        class="text-h4">$magnify</v-icon></v-list-item>
                <v-list-item @click="onLogin" :ripple="false" :active="false" class="text-center pa-2 ml-auto"><v-icon
                        class="text-h4">$login</v-icon></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <login-dialog ref="login" />
    </v-container>
</template>

<script setup>
import LoginDialog from './LoginDialog.vue'
</script>

<script>
export default {
    data: () => ({
        // パスを格納
        // https://qiita.com/kke1229/items/3f41dc44decd61b36c97
        path: '',
    }),
    created() {
        this.path = this.$route.path
    },
    methods: {
        onLogin() {
            this.$refs.login.openLogin()
        },
    },
}
</script>

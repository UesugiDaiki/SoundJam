<template>
    <v-container>
        <v-navigation-drawer permanent>
            <v-list nav class="justify-end">
                <v-list-item to="/home" :ripple="false" :active="false" class="text-h6 font-weight-black text-center ml-auto" width="120px">SoundJam</v-list-item>
                <v-list-item to="/home" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon class="text-h4 text-right">{{
                    path === "/home" ? "$home" : "$homeOutline" }}</v-icon></v-list-item>
                <v-list-item to="/search" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon
                        class="text-h4">$magnify</v-icon></v-list-item>
                <v-list-item to="/notifications" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon class="text-h4">{{
                    path === "/notifications" ? "$bell" : "$bellOutline" }}</v-icon></v-list-item>
                <v-list-item to="/inquiry" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon class="text-h4">{{ path ===
                    "/inquiry" ? "$email" : "$emailOutline" }}</v-icon></v-list-item>
                <v-list-item to="/user" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon class="text-h4">{{ path ===
                    "/user" ? "$account" : "$accountOutline" }}</v-icon></v-list-item>
                <v-list-item to="/settings/notice_setting" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon class="text-h4">{{ path.indexOf('/settings')
                    === 0 ? "$cog" : "$cogOutline" }}</v-icon></v-list-item>
                <v-list-item @click="onPost" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px" value="post"><v-icon class="text-h4">$guitarPickOutline</v-icon></v-list-item>
                <v-list-item @click="onRegistProduct" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px" value="post"><v-icon class="text-h4">$guitarPick</v-icon></v-list-item>
                <v-list-item v-if="loginFlg" @click="onLogout" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon
                        class="text-h4">$logout</v-icon></v-list-item>
                <v-list-item v-if="!loginFlg" @click="onLogin" :ripple="false" :active="false" class="text-center pa-2 ml-auto" width="50px" height="50px"><v-icon
                        class="text-h4">$login</v-icon></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <logout-dialog ref="logout"/>
        <login-dialog ref="login"/>
        <post-dialog ref="post"/>
        <regist-product-dialog ref="registProduct"/>
    </v-container>
</template>

<script setup>
import LogoutDialog from './LogoutDialog.vue'
import LoginDialog from './LoginDialog.vue' 
import PostDialog from './PostDialog.vue'
import RegistProductDialog from './RegistProductDialog.vue'
</script>

<script>
export default {
    data: () => ({
        // パスを格納
        // https://qiita.com/kke1229/items/3f41dc44decd61b36c97
        path: '',
        loginFlg: false,
    }),
    created() {
        this.path = this.$route.path
    },
    methods: {
        onLogout() {
            this.$refs.logout.openLogout()
        },
        onLogin() {
            this.$refs.login.openLogin()
        },
        onPost() {
            this.$refs.post.openPost()
        },
        onRegistProduct() {
            this.$refs.registProduct.openRegistProduct()
        },
    },
}
</script>

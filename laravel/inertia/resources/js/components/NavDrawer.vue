<template>
    <v-container >
        <v-navigation-drawer permanent class="homeBar">
            <v-list nav class="justify-end">
                <!-- SoudJamロゴ -->
                <v-list-subheader style="cursor: pointer;" height="82" width="150" @click="Home" class="justify-end py-2 px-0 font-weight-black text-center ml-auto"><div style="height: 66px;"><v-img :min-width="70" :width="134" src="/assets/sj-logo.svg"></v-img></div></v-list-subheader>
                <!-- ホーム -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="Home" :ripple="false" :active="false" class=" text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon :icon="path === '/home' ? '$home' : '$homeOutline'"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="ホーム" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- 検索 -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="Search" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon icon="$magnify"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="検索" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- お問い合わせ -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="Inquiry" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon :icon="path === '/inquiry' ? '$email' : '$emailOutline'"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="お問い合わせ" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- ユーザー（プロフィール） -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="User" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon :icon="isLoginUserPage ? '$account' : '$accountOutline'"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="プロフィール" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- 設定詳細 -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="Settings" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon :icon="path.indexOf('/settings') === 0 ? '$cog' : '$cogOutline'"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="設定" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- 投稿ダイアログ表示 -->
                <v-list-item class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="onPost" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon icon="$pencilPlusOutline"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="投稿" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- ログアウト時のボタン表示 -->
                <v-list-item v-if="loginFlg === true" class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="onLogout" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon icon="$logout"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="ログアウト" ></v-tooltip>
                    </v-btn>
                </v-list-item>
                <!-- ログイン時のボタン表示 -->
                <v-list-item v-if="loginFlg === false" class="d-flex justify-end pa-0">
                    <v-btn elevation="0" @click="onLogin" :ripple="false" :active="false" class="pa-2 text-h5 rounded" width="50px" height="50px" icon>
                        <v-icon icon="$login"></v-icon>
                        <v-tooltip activator="parent" location="bottom"  text="ログイン" ></v-tooltip>
                    </v-btn>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- ダイアログ各種 -->
        <logout-dialog ref="logout"/>
        <login-dialog ref="login"/>
        <post-dialog ref="post"/>
    </v-container>
</template>

<script setup>
import LogoutDialog from './LogoutDialog.vue'
import LoginDialog from './LoginDialog.vue'
import PostDialog from './PostDialog.vue'
</script>

<script>
export default {
    data: () => ({
        // パスを格納
        // https://qiita.com/kke1229/items/3f41dc44decd61b36c97
        path: '',
        loginFlg: null,
        session: null,
    }),
    //ページロード時実行
    created() {
        this.path = this.$route.path
        this.getLogin()
    },
    computed: {
        isLoginUserPage() {
            return (
                this.session !== null
                && this.session.data == this.path.replace('/user/', '')
            )
        }
    },
    methods: {
        //ログインページ起動
        onLogout() {
            this.$refs.logout.openLogout()
        },
        // ログアウトページ起動
        onLogin() {
            this.$refs.login.openLogin()
        },
        //投稿登録ダイアログを表示
        onPost() {
            if (this.loginFlg === false) {
                this.onLogin()
            } else {
                // 投稿ダイアログを表示
                this.$refs.post.openPost()
            }
        },
        //ログイン状態か確認
        async getLogin() {
            // user_idを取得
            this.session = await axios.get('/api/getSession')
            //　session情報を基にflagを変更
            this.loginFlg = !(this.session['data'] == '');
        },
        //ホーム
        Home() {
            // ホーム画面に遷移
            this.$router.push('/home');
            // ホーム画面でホームのアイコン押された場合
            if(this.$route.path ==  '/home'){
                window.history.go(0)
            }
        },
        //検索
        Search() {
            // 検索画面に遷移
            this.$router.push('/search');
        },
        //お問い合わせ
        Inquiry() {
            //ログイン判定
            if (this.loginFlg === false) {
                this.onLogin()
            } else {
                // お問い合わせ画面に遷移
                this.$router.push('/inquiry');
                // お問い合わせ画面でお問い合わせのアイコン押された場合
                if(this.$route.path ==  '/inquiry'){
                window.history.go(0)
                }
            }
        },
        //ユーザー(プロフィール)
        async User() {
            //ログイン判定
            if (this.loginFlg === false) {
                this.onLogin()
            } else {
                // プロフィール画面に遷移
                // this.$router.push('/user');
                this.$router.push({name: 'user', params: {userId: this.session['data']}});
            }
        },
        //設定
        Settings() {
            //ログイン判定
            if (this.loginFlg === false) {
                this.onLogin()
            } else {
                // 設定画面に遷移
                this.$router.push('/settings/reset_password');
            }
        },
    },
}
</script>

<style scoped>
.homeBar{
    /* 画面が850px以上の場合適応 */
    width: 18% !important ;
    /* !importantはあまりよろしくないのかも？？ */
}
    
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .homeBar{
            width: 24% !important ;
        }
    }
</style>

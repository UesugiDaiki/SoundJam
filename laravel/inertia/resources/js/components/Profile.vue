<template>
    <v-row class="pl-3" justify="center">
        <v-card width="570px" rounded="0" elevation="0">
            <!-- アイコン、ユーザー名 -->
            <v-card-title class="d-flex">
                <v-avatar :image="'../../storage/user/' + user.id + '/' + user.ICON" size="150"></v-avatar>
                <v-card-title class="my-auto text-h5 font-weight-bold">{{ user.USER_NAME }}</v-card-title>
                <v-spacer></v-spacer>
                <!-- ログイン済アカウント -->
                <v-btn class="my-auto mx-1" v-if="loggedInAccount" icon="$cogOutline" elevation="0" @click="onEditProfile"></v-btn>
                <!-- end -->

                <!-- 他アカウント -->
                <v-btn class="my-auto mx-1" v-if="!loggedInAccount && !followed" color="primary" elevation="0" rounded
                    height="48" :disabled="creating" @click="follow">フォロー</v-btn>
                <v-btn class="my-auto mx-1" v-if="!loggedInAccount && followed" elevation="0" rounded
                    height="48" :disabled="creating" @click="unFollow">フォロー解除</v-btn>
                <v-btn class="my-auto mx-1" v-if="!loggedInAccount" icon="$bellOutline" elevation="0" :disabled="creating"></v-btn>
                <!-- end -->
            </v-card-title>
            <v-sheet class="ma-3">
                <v-card-subtitle><v-icon class="mx-2">$at</v-icon>{{ user.id }}</v-card-subtitle>
                <v-card-subtitle v-if="user.WEBSITE !== null"><v-icon class="mx-2">$link</v-icon>{{ user.WEBSITE }}</v-card-subtitle>
            </v-sheet>
            <v-card rounded="0" elevation="0">
                <v-card-text style="color: #666">
                    {{ user.PROFILES }}
                </v-card-text>
            </v-card>
        </v-card>
        <v-divider length="570"></v-divider>
    </v-row>

    <edit-profile-dialog ref="editProfile" :user="user"/>
</template>

<script setup>
import axios from 'axios';
import EditProfileDialog from './EditProfileDialog.vue'
</script>

<script>
export default {
    data: () => ({
        session: {data: null},
        creating: true,
        followed: false,
        userId: null,
    }),
    computed: {
        loggedInAccount() {
            return this.userId === this.session.data
        }
    },
    props: {
        user: Object,
    },
    async created() {
        // 表示しているユーザーのID、ログインしているユーザーのID取得
        this.userId = Number(this.$route.path.replace('/user/', ''))
        this.session = await axios.get('/api/getSession')
        if (!this.loggedInAccount) {
            // フォローしているか判定
            let getFollowData = {
                loginAccountId: this.session.data,
                userId: this.userId,
            }
            let _followed;
            await axios.post('/api/getFollow', getFollowData)
                .then(function(response){
                    console.log('フォロー情報取得成功')
                    _followed = response.data
                })
                .catch(function(error){
                    console.log('フォロー情報取得失敗')
                })
            this.followed = _followed
        }
        this.creating = false
    },
    methods: {
        // プロフィール編集ダイアログ表示
        onEditProfile() {
            this.$refs.editProfile.openEditProfile()
        },
        // フォロー
        async follow() {
            let followData = {
                loginAccountId: this.session.data,
                userId: this.userId,
            }
            let successFlg = false
            await axios.post('/api/follow', followData)
                .then(function(response) {
                    console.log('フォロー成功')
                    successFlg = true
                })
                .catch(function(error) {
                    console.log('フォロー失敗')
                    successFlg = false
                })
            
            if (successFlg) {
                this.followed = true
            }
        },
        // フォロー解除
        async unFollow() {
            let unFollowData = {
                loginAccountId: this.session.data,
                userId: this.userId,
            }
            let successFlg = false
            await axios.post('/api/unFollow', unFollowData)
                .then(function(response) {
                    console.log('フォロー解除成功')
                    successFlg = true
                })
                .catch(function(error) {
                    console.log('フォロー解除失敗')
                    successFlg = false
                })

            if (successFlg) {
                this.followed = false
            }
        }
    }
}
</script>

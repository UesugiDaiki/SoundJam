<template>
    <v-col class="like-icon d-flex flex-row justify-end" width="30px">
        <router-link to="#">
            <div class="text-center" v-bind:class="likeIconClass" v-on:click="likeOnOff($event)"
                style="height: 2.8rem; width: 2.8rem;">
                <v-icon style="margin-top: 7px;">{{ likeIcon }}</v-icon>
            </div>
        </router-link>
        <!-- 適当に置いた良いね数 -->
        <v-card-text aria-disabled="true">100000</v-card-text>
    </v-col>
</template>

<script>
export default {
    name: 'HelloWold',
    //ページロード時実行
    async created() {
        await this.getLogin()
    },
    data() {
        return {
            title: 'Trans&Anim',
            message: 'Transition sample!',
            flg: true,
            btn: 'Show/Hide',
            likeIcon: '$musicNoteHalf',
            // $musicNoteHalf オフ 2分音符
            // $musicNoteEighth オン 8分音符
            likeIconClass: 'like-button',
            session: null,
        }
    },
    methods: {
        //ログイン状態か確認
        async getLogin() {
            // user_idを取得
            this.session = await axios.get('api/getSession')
        },
        //フラグ変化
        doAction() {
            this.flg = !this.flg
        },
        //非同期処理
        async likeOnOff(event) {
            event.preventDefault()
            // 現在のいいねアイコンが2分音符(オフ)の場合かつログイン状態の場合
            if (this.likeIcon == '$musicNoteHalf' && !(this.session['data'] == '')) {
                //　良いね登録
                await axios.post('/api/createLike', {postId: this.postId})
                    .then(function(response) {
                            console.log('成功');
                            // successFlg = true
                        })
                        .catch(function(error) {
                            console.log('失敗');
                            // successFlg = false
                        })
                // 見た目を8分音符(オン)に
                this.likeIcon = '$musicNoteEighth'
                // like-role cssをオン
                this.likeIconClass = 'like-role'
            } else if (!(this.session['data'] == '')) {
                //8分音符(オン)の場合
                // 見た目を2分音符(オフ)に
                this.likeIcon = '$musicNoteHalf'
                // like-role cssをオフ
                this.likeIconClass = 'cancel-like-role'
            }else {
                // ログインしていない場合
                alert('ログインしてください');
            }
            return false
        },
    },
    //投稿ID受け取り
    props: {
            postId: Number,
    }
}
</script>
<style scoped>
.like-icon a {
    color: inherit;
}
</style>

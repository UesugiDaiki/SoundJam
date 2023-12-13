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
        }
    },
    methods: {
        //フラグ変化
        doAction() {
            this.flg = !this.flg
        },
        //非同期処理
        async likeOnOff(event) {
            event.preventDefault()
            // 現在のいいねアイコンが2分音符(オフ)の場合
            if (this.likeIcon == '$musicNoteHalf') {
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
            }
            //8分音符(オン)の場合
            else {
                // 見た目を2分音符(オフ)に
                this.likeIcon = '$musicNoteHalf'
                // like-role cssをオフ
                this.likeIconClass = 'cancel-like-role'
            }
            return false
        },
        //投稿ID受け取り
        props: {
            postId: Number,
        }
    }
}
</script>
<style scoped>
.like-icon a {
    color: inherit;
}
</style>

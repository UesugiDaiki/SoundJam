<template>
    <v-col class="like-icon d-flex flex-row justify-end" width="30px">
        <router-link to="#">
            <div class="text-center" v-bind:class="likeIconClass" v-on:click="likeOnOff($event)"
                style="height: 2.8rem; width: 2.8rem;">
                <v-icon style="margin-top: 7px;">{{ likeIcon }}</v-icon>
            </div>
        </router-link>
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
        doAction() {
            this.flg = !this.flg
        },
        likeOnOff(event) {
            event.preventDefault()
            // 現在のいいねアイコンが2分音符(オフ)の場合
            if (this.likeIcon == '$musicNoteHalf') {
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
        }
    }
}
</script>
<style scoped>
.like-icon a {
    color: inherit;
}
</style>
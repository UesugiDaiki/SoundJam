<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 投稿をレビュー、自由投稿ごちゃ混ぜにいいねが多い順に表示 -->
        <!-- forで表示 -->
        <PostFree :post="posts[1]" />
        <PostReview :post="posts[0]" />
        <PostReview :post="posts[0]" />
        <PostReview :post="posts[0]" />
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import PostFree from '@/components/PostFree.vue'
import PostReview from '@/components/PostReview.vue'
</script>

<script>
export default {
    data: () => ({
        // 投稿データ
        posts: [
            {
                name: "雅弥",
                myImg: "assets/masaya.png",
                title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
                img: "assets/ms50g.png",
                music1: "assets/maou_bgm_piano40.mp3",
                music2: "assets/maou_bgm_fantasy15.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    { text: 'YAMAHA REVSTAR420' },
                    { text: 'CANARE シールド' },
                    { text: 'BOSS MS-50g' },
                    { text: 'CANARE シールド' },
                    { text: 'PRESONUS Studio 24c' },
                ],
            },
            {
                name: "雅弥",
                myImg: "assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "assets/AC-3.jpg",
                music: "assets/maou_bgm_acoustic54.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    { text: 'YAMAHA REVSTAR420' },
                    { text: 'CANARE シールド' },
                    { text: 'BOSS AC-3' },
                    { text: 'BOSS Equalizer GE-7' },
                    { text: 'CANARE シールド' },
                    { text: 'PRESONUS Studio 24c' },
                ],
            },
        ]
    })
}
</script>
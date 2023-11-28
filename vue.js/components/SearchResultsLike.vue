<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 投稿をレビュー、自由投稿ごちゃ混ぜにいいねが多い順に表示 -->
        <!-- forで表示 -->
        <post v-for="post in posts" :post="post" />
    <!-- </v-skeleton-loader> -->
</template>

<script setup>
import Post from '@/components/Post.vue'
</script>

<script>
export default {
    data: () => ({
        // 投稿データ
        posts: [
        {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
                img: "src/assets/ms50g.png",
                music1: "src/assets/maou_bgm_piano40.mp3",
                music2: "src/assets/maou_bgm_fantasy15.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    'YAMAHA REVSTAR420',
                    'CANARE シールド',
                    'BOSS MS-50g',
                    'CANARE シールド',
                    'PRESONUS Studio 24c',
                ],
                type: true,
            },
            {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "src/assets/AC-3.jpg",
                music: "src/assets/maou_bgm_acoustic54.mp3",
                recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
                items: [
                    'YAMAHA REVSTAR420',
                    'CANARE シールド',
                    'BOSS AC-3',
                    'BOSS Equalizer GE-7',
                    'CANARE シールド',
                    'PRESONUS Studio 24c',
                ],
                type: false,
            },
        ]
    })
}
</script>
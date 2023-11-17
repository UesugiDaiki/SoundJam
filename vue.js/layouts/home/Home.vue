<template>
    <v-app>
        <nav-drawer />

        <v-main class="mt-n5">
            <post-review :post="posts[0]"/>
            <post-free :post="posts[1]"/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import PostReview from '@/components/PostReview.vue'
import PostFree from '@/components/PostFree.vue'
</script>

<script>
export default {
    data: () => ({
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
                    { text: 'YAMAHA REVSTAR420' },
                    { text: 'CANARE シールド' },
                    { text: 'BOSS MS-50g' },
                    { text: 'CANARE シールド' },
                    { text: 'PRESONUS Studio 24c' },
                ],
            },
            {
                name: "雅弥",
                myImg: "src/assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "src/assets/AC-3.jpg",
                music: "src/assets/maou_bgm_acoustic54.mp3",
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
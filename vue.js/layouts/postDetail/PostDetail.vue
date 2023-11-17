<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <edit-review :post="post" />
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import EditReview from '@/components/EditReview.vue'
</script>

<script>
export default {
    data: () => ({
        post: {
            name: "雅弥",
            myImg: "src/assets/masaya.png",
            title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
            img: "src/assets/ms50g.png",
            music1: "src/assets/maou_bgm_piano40.mp3",
            music2: "src/assets/maou_bgm_fantasy15.mp3",
            overview: "概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要",
            recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
            items: [
                { text: 'YAMAHA REVSTAR420' },
                { text: 'CANARE シールド' },
                { text: 'BOSS MS-50g' },
                { text: 'CANARE シールド' },
                { text: 'PRESONUS Studio 24c' },
            ],
        },
    }),
}
</script>
<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title title="プロフィール編集" />
            <edit-profile :user="user"/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import PageTitle from '@/components/PageTitle.vue'
import EditProfile from '@/components/EditProfile.vue';
</script>

<script>
export default {
    data: () => ({
        user: {
            id: '12345',
            name: '雅弥',
            link: 'link',
            profile: 'プロフィールプロフィールプロフィールプロフィールプロフィール',
        },
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
    }),
}
</script>
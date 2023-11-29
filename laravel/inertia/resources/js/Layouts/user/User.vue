<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title :title="user.name" />
            <profile :user="user" />
            <post v-for="post in posts" :post="post"/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import PageTitle from '@/components/PageTitle.vue'
import Profile from '@/components/Profile.vue'
import Post from '@/components/Post.vue'
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
                myImg: "assets/masaya.png",
                title: "エレキギターをアコギの音に！！！",
                img: "assets/AC-3.jpg",
                music: "assets/maou_bgm_acoustic54.mp3",
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
    }),
}
</script>
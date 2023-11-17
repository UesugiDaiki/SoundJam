<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title title="通知"/>

            <v-list lines="two">
                <follow-notif />

                <like-notif />
                <like-notif />
                <like-notif />
                <like-notif />
                <like-notif />
                <like-notif />
                <like-notif />

                <post-notif />
                <post-notif />
                <like-notif />
                <post-notif />
                <post-notif />
                <post-notif />
            </v-list>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import FollowNotif from '@/components/FollowNotif.vue'
import LikeNotif from '@/components/LikeNotif.vue'
import PostNotif from '@/components/PostNotif.vue'
import PageTitle from '@/components/PageTitle.vue'
</script>
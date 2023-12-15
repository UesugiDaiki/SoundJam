<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title title="通知"/>

            <v-list lines="two">
                <notification v-for="notification in notifications" :notification="notification"/>
            </v-list>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import Notification from '@/components/Notification.vue'
import PageTitle from '@/components/PageTitle.vue'
</script>

<script>
export default {
    created() {
        axios.get('/api/getNotice')
    },
    data: () => ({
        notifications: [
            {
                type: 'follow',
                userName: '雅弥',
                userIcon: 'assets/masaya.png',
            },
            {
                type: 'like',
                postTitle: 'エレキギターをアコギの音に！！！',
            },
            {
                type: 'like',
                postTitle: 'エレキギターをアコギの音に！！！',
            },
            {
                type: 'like',
                postTitle: 'エレキギターをアコギの音に！！！',
            },
            {
                type: 'post',
                userName: '雅弥',
                userIcon: 'assets/masaya.png',
                postTitle: 'ZOOM/ MS-50G マルチストンプ マルチエフェクター',
            },
            {
                type: 'post',
                userName: '雅弥',
                userIcon: 'assets/masaya.png',
                postTitle: 'エレキギターをアコギの音に！！！',
            }
        ]
    }),
}
</script>
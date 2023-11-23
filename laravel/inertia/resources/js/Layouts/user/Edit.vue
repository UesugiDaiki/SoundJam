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
    }),
}
</script>
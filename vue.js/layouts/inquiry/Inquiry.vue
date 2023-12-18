<template>
    <v-app>
        <nav-drawer />

        <v-main>
            <page-title title="サポート"/>

            <v-expansion-panels>
                <an-inquiry v-for="inquiry in inquiries" :inquiry="inquiry" />
                <v-divider></v-divider>
            </v-expansion-panels>

            <inquiry-button/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/components/NavDrawer.vue'
import AnInquiry from '@/components/AnInquiry.vue';
import InquiryButton from '@/components/InquiryButton.vue'
import PageTitle from '@/components/PageTitle.vue';
</script>

<script>
export default {
    data() {
        return {
            inquiries: [
                {
                    title: '利用規約違反警告',
                    content: '規約違反規約違反規約違反規約違反規約違反規約違反規約違反規約違反規約違反規約違反',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
                {
                    title: 'あいう',
                    content: 'あいうえお',
                },
            ],
        }
    },
}
</script>
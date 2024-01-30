<template>
    <v-app>
        <nav-drawer />

        <v-main class="leftLength">
            <page-title title="サポート"/>
            
            <v-expansion-panels>
                <an-inquiry v-for="inquiry in inquiries" :inquiry="inquiry" />
                <an-inquiry v-if="inquiries.length < 10" :inquiry="{TITLE: 'ご登録ありがとうございます', OVERVIEW: 'SoundJamにご登録いただきありがとうございます'}"/>
                <v-divider></v-divider>
            </v-expansion-panels>

            <inquiry-button/>
        </v-main>
    </v-app>
</template>

<script setup>
import NavDrawer from '@/Components/NavDrawer.vue'
import AnInquiry from '@/Components/AnInquiry.vue';
import InquiryButton from '@/Components/InquiryButton.vue'
import PageTitle from '@/Components/PageTitle.vue';
</script>

<script>
export default {
    async created() {
        let _inquiries = await axios.get('/api/getInquiry')
        this.inquiries = _inquiries.data
    },
    data() {
        return {
            inquiries: [],
        }
    },
}
</script>

<style scoped>
.leftLength{
    /* 画面が850px以上の場合適応 */
    --v-layout-left: 18% !important;
}
    
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .leftLength{
            --v-layout-left: 24% !important;
        }
    }
</style>
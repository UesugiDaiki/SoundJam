<template>
    <v-btn @click="onInquiry" class="rounded-circle" height="64px" width="64px" style="z-index: 2; bottom: 50px; right: 50px; position:fixed;">
        <v-icon class="text-h4">$pencil</v-icon>
    </v-btn>

    <inquiry-dialog ref="inquiry"/>
</template>

<script setup>
import InquiryDialog from './InquiryDialog.vue'
</script>

<script>
export default {
    methods: {
        onInquiry() {
            this.$refs.inquiry.openInquiry()
        },
    }
}
</script>
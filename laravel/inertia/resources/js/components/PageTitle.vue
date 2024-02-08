<template >
    <v-app-bar class="barLeftLength" color="white" elevation="0" width="100%">
        <v-btn class="ma-1" variant="text" icon="$arrowLeft" onclick="window.history.back();"></v-btn>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
    </v-app-bar>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: '',
        }
    }
}
</script>

<style scoped>
.barLeftLength{
    /* ‰æ–Ê‚ª850pxˆÈã‚Ìê‡“K‰ */
    left: 18% !important;
}
    
    /* ‰æ–Ê‚ª850pxˆÈ‰º‚Ìê‡“K‰ */
    @media screen and (max-width: 850px) {
        .barLeftLength{
            left: 24% !important;
        }
}
</style>
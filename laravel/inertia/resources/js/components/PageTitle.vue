<template >
    <v-app-bar class="barLeftLength" color="white" elevation="0">
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
    /* 画面が850px以上の場合適応 */
    left: 18% !important;
}
    
    /* 画面が850px以下の場合適応 */
    @media screen and (max-width: 850px) {
        .barLeftLength{
            left: 24% !important;
        }
}
</style>
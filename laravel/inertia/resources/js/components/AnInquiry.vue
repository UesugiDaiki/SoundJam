<template>
    <v-expansion-panel rounded="0" elevation="0" :key="inquiry" :title="inquiry.TITLE" :text="inquiry.OVERVIEW"></v-expansion-panel>
</template>

<script>
export default {
    props: {
        inquiry: Object,
    }
}
</script>
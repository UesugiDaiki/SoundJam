<template>
    <v-expansion-panel rounded="0" elevation="0" :key="inquiry" :title="inquiry['title']" :text="inquiry['content']"></v-expansion-panel>
</template>

<script>
export default {
    props: {
        inquiry: Object,
    }
}
</script>
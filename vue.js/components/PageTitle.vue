<template>
    <v-app-bar color="white" elevation="0">
        <v-toolbar-title>{{ title }}</v-toolbar-title>
    </v-app-bar>
</template>

<script>
export default {
    props: {
        title: String,
    }
}
</script>
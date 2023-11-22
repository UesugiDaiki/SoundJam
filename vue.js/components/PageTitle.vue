<template>
    <v-app-bar color="white" elevation="0">
        <v-btn
        class="ma-2"
        variant="text"
        icon="$arrowLeft"
        onclick="window.history.back();"
      ></v-btn>
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
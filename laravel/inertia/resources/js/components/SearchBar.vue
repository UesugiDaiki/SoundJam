<template>
    <v-responsive class="mx-auto" min-width="340" max-width="460">
        <v-text-field flat rounded bg-color="black" density="compact" variant="solo" append-inner-icon="$magnify" single-line hide-details @click:append-inner="search" v-model="searchWords"></v-text-field>
    </v-responsive>
</template>

<script>
export default {
    data: () => ({
        searchWords: "",
    }),
    props: {
        tab: Number,
    },
    method: {
        search() {

        }
    }
}
</script>
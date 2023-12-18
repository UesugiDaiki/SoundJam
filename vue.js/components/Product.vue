<template>
    <v-row class="pl-3" justify="center">
        <v-card justify="center" class="mx-auto px-4 py-2" width="570px" max-width="570" min-width="200" rounded="0"
            elevation="0"  link to="/detail">
            <v-card-title class="d-flex pa-0">
                <v-avatar :image="product.img" size="47"></v-avatar>
                <v-card-text style="font-size: 20px;" class="txt-limit">
                    {{ product.name }}
                </v-card-text>
                <v-icon size="50" icon="$chevronRight"></v-icon>
            </v-card-title>
        </v-card>
        <v-divider length="570px"></v-divider>
    </v-row>
</template>

<script>
export default {
    props: {
        product: Object,
    }
}
</script>

<style>
/* í∑Ç∑Ç¨ÇÈÇ∆è»ó™Ç∑ÇÈcss */
.txt-limit {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
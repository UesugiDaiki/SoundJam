<template>
        <v-row class="pl-3" justify="center">
            <v-card justify="center" class="mx-auto px-4 py-2" width="570px" max-width="570" min-width="200" rounded="0" elevation="0"
                style="border: 1px solid #ddd;" link to="/detail">
                <v-card-title class="d-flex pa-0">
                    <v-avatar :image="product.img" size="47" ></v-avatar>
                    <v-card-text style="font-size: 20px;" >
                        {{ product.name }}
                    </v-card-text> 
                    <v-icon size="50" icon="$chevronRight"></v-icon>
                </v-card-title>
            </v-card>
        </v-row>
</template>

<script>
export default {
    // data: () => ({}),
    props: {
        product: Object,
    }
}
</script>
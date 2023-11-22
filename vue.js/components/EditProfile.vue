<template>
    <v-row class="pl-3" justify="center">
        <v-card width="570px" rounded="0" elevation="0">
            <v-card-title class="d-flex">
                <v-sheet>
                    <v-file-input class="my-auto" prepend-icon=""></v-file-input>
                </v-sheet>
                <v-sheet>
                    <v-text-field class="my-auto text-h5 font-weight-bold" v-model="user.name"></v-text-field>
                </v-sheet>
                <v-spacer></v-spacer>
                <v-btn class="my-auto mx-1" elevation="0" rounded height="48">保存</v-btn>
            </v-card-title>
            <v-sheet class="ma-3">
                <v-sheet style="color: #666" class="d-flex"><v-icon class="mx-2 my-auto">$at</v-icon><v-text-field class="my-auto" v-model="user.id"></v-text-field></v-sheet>
                <v-sheet style="color: #666" class="d-flex"><v-icon class="mx-2 my-auto">$link</v-icon><v-text-field class="my-auto" v-model="user.link"></v-text-field></v-sheet>
            </v-sheet>
            <v-card rounded="0" elevation="0">
                <v-card-text style="color: #666">
                    <v-text-field v-model="user.profile"></v-text-field>
                </v-card-text>
            </v-card>
        </v-card>
        <v-divider length="570"></v-divider>
    </v-row>
</template>

<script>
export default {
    props: {
        user: Object,
    }
}
</script>
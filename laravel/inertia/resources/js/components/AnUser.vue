<template>
    <v-row  class="pl-3" justify="center" >
        <v-sheet style="width: 570px;">
            <v-card  class="mx-auto px-4 py-2" max-width="570px" rounded="0" elevation="0" link :to="{name: 'user', params: {userId: user.id}}">

                <v-card-title class="d-flex pa-0">
                    <!-- ?A?C?R?? -->
                    <v-avatar :image="'../../storage/user/' + user.id + '/' + user.ICON" size="47"></v-avatar>
                    <!-- ?A?J?E???g?? -->
                    <v-card-text style="font-size: 20px; " class="px-1 py-0 ">
                        <v-card-title class="pa-0" style="height: 28px; ">{{ user.USER_NAME }}</v-card-title>

                        <v-card-subtitle class="pl-0" ><v-icon class="mx-0">$at</v-icon>{{ user.id }}</v-card-subtitle>
                    </v-card-text>
                    <!-- ???[?U?[ID -->
                    <!-- ??????? -->
                    <v-icon size="50" icon="$chevronRight"></v-icon>
                </v-card-title>
            </v-card>
            <v-divider length="570px"></v-divider>
        </v-sheet>   
         </v-row>
</template>

<script>
export default {
    // data: () => ({}),
    props: {
        user: Object,
    }
}
</script>

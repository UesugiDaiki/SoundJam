<template>
    <v-row class="pl-3" justify="center">
        <v-card justify="center" class="mx-auto px-4 py-2" width="570px" max-width="570" min-width="200" rounded="0" elevation="0"
            link to="/profile">
            <v-card-title class="d-flex pa-0">
                <!-- ?A?C?R?? -->
                <v-avatar :image="user.icon" size="47" style="font-size: " ></v-avatar>
                <!-- ?A?J?E???g?? -->
                <v-card-text style="font-size: 20px; " class="px-2 py-0 ">
                    <v-card-title class="pa-0" style="height: 28px;">{{ user.name }}</v-card-title>
                    
                    <v-card-subtitle class="pl-0"><v-icon class="mx-0">$at</v-icon>{{ user.id }}</v-card-subtitle>
                </v-card-text> 
                <!-- ???[?U?[ID -->
                <!-- ??????? -->
                <v-icon size="50" icon="$chevronRight"></v-icon>
            </v-card-title>
        </v-card>
        <v-divider length="570px"></v-divider>

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
<template>
    <v-list-item :ripple="false" link title="投稿がいいねされました">
        <template v-slot:subtitle>
            {{ notification.postTitle }}
        </template>
    </v-list-item>

    <v-divider></v-divider>
</template>

<script>
export default {
    props: {
        notification: Object,
    }
}
</script>
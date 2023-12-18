<template>
    <v-list-item :ripple="false" link :prepend-avatar="notification.userIcon" :title="notification.userName + 'さんが投稿しました'">
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
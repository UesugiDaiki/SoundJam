<template>
    <follow-notif v-if="notification.type === 'follow'" :notification="notification"/>
    <like-notif v-if="notification.type === 'like'" :notification="notification"/>
    <post-notif v-if="notification.type === 'post'" :notification="notification"/>
</template>

<script setup>
import FollowNotif from '@/components/FollowNotif.vue'
import LikeNotif from '@/components/LikeNotif.vue'
import PostNotif from '@/components/PostNotif.vue'
</script>

<script>
export default {
    props: {
        notification: Object,
    }
}
</script>
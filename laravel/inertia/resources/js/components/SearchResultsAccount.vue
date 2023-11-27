<template>
    <an-user v-for="user in users" :user="user" />
</template>

<script setup>
import AnUser from '@/components/AnUser.vue'
</script>

<script>
export default {
    data: () => ({
        //  ユーザーデータ
        users:[
            {
                id: '12345',
                name: '園田',
                icon: 'assets/masaya.png',
            },
            {
                id: '56789',
                name: '雅弥',
                icon: 'assets/rock.png',
            },
            {
                id: '11111',
                name: 'Masayaaaaaa',
                icon: 'assets/paper.png',
            },
        ],
    })
}
</script>
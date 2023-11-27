<template>
    <!-- 読み込み中に見た目でるやつ -->
    <!-- <v-skeleton-loader> -->
        <!-- 検索に引っかかったアカウント-->
        <!-- forで表示 -->
        <an-user v-for="user in users" :user="user" />
    <!-- </v-skeleton-loader> -->
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
                icon: 'src/assets/masaya.png',
            },
            {
                id: '56789',
                name: '雅弥',
                icon: 'src/assets/rock.png',
            },
            {
                id: '11111',
                name: 'Masayaaaaaa',
                icon: 'src/assets/paper.png',
            },
        ],
    })
}
</script>
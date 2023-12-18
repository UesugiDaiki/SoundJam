<template>
    <div>
        <p v-for="user in users">
            {{ user }}
        </p>
        <!-- <p v-for="post in posts">
            {{ post }}
        </p> -->
        {{ message }}
    </div>
    <!-- <table>


        <theab class="mt-n5">
            <post-review :post="posts[0]"/>
            <post-free :post="posts[1]"/>
            <tr>
                <th>Name</th>
                <th>Mail</th>
            </tr>
        </theab>
        <tr v-for="user in users">
            <th>{{ user.id }}</th>
            <th>{{ user.USER_NAME }}</th>
        </tr>
    </table> -->
    <!-- <component v-for="post in posts" :post="post" /> -->
</template>

<script>
// import component from '@/component.vue'
export default {
    created() {
        this.hello();
        this.test();
    },
    methods: {
        async hello() {
            const res = await axios.get("/api/hello");
            this.message = res.data;
        },
        async test() {
            const res = await axios.get("/api/test");
            this.users = res.data;
            // this.posts = res.data;
        },
    },
    data: () => ({
        message: "",
        users: [],
        // posts: [],
        // posts: [
        //     {
        //         name: "雅弥",
        //         myImg: "/assets/masaya.png",
        //         title: "ZOOM/ MS-50G マルチストンプ マルチエフェクター",
        //         img: "/assets/ms50g.png",
        //         music1: "/assets/maou_bgm_piano40.mp3",
        //         music2: "/assets/maou_bgm_fantasy15.mp3",
        //         recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
        //         items: [
        //             { text: 'YAMAHA REVSTAR420' },
        //             { text: 'CANARE シールド' },
        //             { text: 'BOSS MS-50g' },
        //             { text: 'CANARE シールド' },
        //             { text: 'PRESONUS Studio 24c' },
        //         ],
        //     },
        //     {
        //         name: "雅弥",
        //         myImg: "/assets/masaya.png",
        //         title: "エレキギターをアコギの音に！！！",
        //         img: "/assets/AC-3.jpg",
        //         music: "/assets/maou_bgm_acoustic54.mp3",
        //         recording: "PRESONUS Studio 24cからPCに取り込みました。DTMのソフトはStudio one5のArtistを使用しました。",
        //         items: [
        //             { text: 'YAMAHA REVSTAR420' },
        //             { text: 'CANARE シールド' },
        //             { text: 'BOSS AC-3' },
        //             { text: 'BOSS Equalizer GE-7' },
        //             { text: 'CANARE シールド' },
        //             { text: 'PRESONUS Studio 24c' },
        //         ],
        //     },
        // ]
    }),
}
</script>

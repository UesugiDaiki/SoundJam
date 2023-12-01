<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" scrollable min-width="320" width="640">
            <v-card>
                <v-card-actions>
                    <v-btn density="comfortable" icon="$close" @click="dialog = false"></v-btn>
                </v-card-actions>
                <v-card-title class="text-center">
                    製品登録
                </v-card-title>

                <v-card-text>
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="12" class="pb-0">
                                <v-text-field label="製品名" v-model="product" required></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field label="概要" v-model="overview" required></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-file-input prepend-icon="" prepend-inner-icon="$camera" @change="fileSelect" required></v-file-input>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn variant="flat" class="me-4" type="submit" color="primary" @click="postProducts">
                                登録
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            //製品
            product: '',
            //概要
            overview: '',
            //イメージ画像
            selected_file: null,

            dialog: false,
            tab: null,
            freeProducts: [
                { id: 0, item: '製品名１' },
                { id: 1, item: '製品名２' }
            ],
            reviewProducts: [
                { id: 0, item: '製品名１' },
            ],
        }
    },
    methods: {
        openRegistProduct() {
            this.dialog = true
        },
        //ファイル選択時の処理
        fileSelect: function(e) {
            //選択したファイルの情報を取得しプロパティにいれる
            this.selected_file = e.target.files[0];
        },
        //送信処理
        postProducts() {
            console.log(this.selected_file);
            console.log(this.product);
            console.log(this.overview);
            //formDataをnewする
            let formData = new FormData();

            //appendでデータを追加(第一引数は任意のキー)
            //他に送信したいデータがある場合にはその分appendする
            formData.append('file', this.selected_file);
            formData.append('product', this.product);
            // formData.append('overview', 'overview');
            formData.append('overview', this.overview);


            let config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post('/api/product', formData, config)
                .then(function(response) {
                    console.log('成功')
                })
                .catch(function(error) {
                    console.log('失敗');
                    console.log(error);
                })
        }
    }
}
</script>

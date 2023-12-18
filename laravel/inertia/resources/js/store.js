//vuex:状態管理ライブラリ（オブジェクトをコンポーネント間で共有出来たりする）
import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

//個人情報など重要な情報は格納しない。

export const store = createStore({
    plugins: [createPersistedState()],
    //state：ストアに保管する値を用意する場所。
    state: {
        //投稿データを格納
        postData: Object,
    },
    // stateのデータにアクセスする役割を持つ
    // オブジェクトのデータにアクセスするアクセッサ的なイメージ
    mutations: {
        addData(state, data) {
            //投稿データのオブジェクトを格納
            state.postData = data;
            //成功表示
            console.log('store成功：' + state.postData);
        },
        // addPostDetailData(state, {n1, n2}) {
        //     state.postDetailData = n1;
        //     state.detailFlg = n2;
        //     console.log( 'state' + state.detailFlg);
        // }
    },
    //これをしないとデータが保持されない
    plugins: [createPersistedState(
        {
        // ストレージに保存する際のキーを指定。デフォルトではvuex
        key: 'myApp',
        // 管理対象のステート(state)を指定
        paths: [
            'postData',
        ],
        // ストレージの種類を指定。デフォルトではローカルストレージ
        //ローカルストレージだと意図的に消さないと情報が端末に残るのでダメ。
        //セッションに設定
            storage: window.sessionStorage,
        }
    )]
})

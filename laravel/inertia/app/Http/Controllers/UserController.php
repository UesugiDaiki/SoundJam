<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class UserController extends Controller
{
    // 投稿全件取得
    public function get_posts()
    {
        $posts = [];
        // id列の値を基準に昇順
        $tmp_posts = DB::select('SELECT * FROM post_table ORDER BY id DESC');
        foreach ($tmp_posts as $post) {
            $items = [];
            // 1投稿ずつのJSON整形

            // オブジェクト -> 連想配列
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            // ユーザー名
            $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id=' . $post["USER_ID"]);
            foreach ($user as $value) {
                $post_key[] = 'USER_NAME';
                $post_key[] = 'ICON';
                $value = (array)$value;
                $post_value[] = $value["USER_NAME"];
                $post_value[] = $value["ICON"];
            }
            // 製品名
            $product_name = DB::select('SELECT NAME FROM product_table WHERE id=' . $post["PRODUCT_ID"]);
            foreach ($product_name as $value) {
                $post_key[] = 'PRODUCT_NAME';
                $value = (array)$value;
                $post_value[] = $value["NAME"];
            }
            // 使用機材
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id=' . $post["id"]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;
            Log::debug($items);

            $post = array_combine($post_key, $post_value);

            array_push($posts, $post);
        };
        Log::debug($posts);
        return $posts;
    }


    //　製品データをDBの製品テーブルに登録
    public function product(Request $request)
    {
        //　ファイル名取得
        $file_name = $request->file('file')->getClientOriginalName();

        // storage/app/publicに、画像ファイルを保存
        $request->file('file')->storeAs('public/product', $file_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        // Log::debug($request->file('file'));
        // Log::debug($product);
        // Log::debug($overview);

        if (DB::table('product_table')->insert([
            'name' => $product,
            'image' => 'storage/product/' . $file_name,
            'overview' => $overview,
            'temp_regist' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
    }


    //　自由投稿をDBに登録
    public function postcreate(Request $request)
    {
        //　音声ファイル名取得
        $mp3_name = $request->file('mp3')->getClientOriginalName();
        // storage/app/publicに、音声ファイルを保存
        $request->file('mp3')->storeAs('public/music', $mp3_name);

        //　画像ファイル名取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');

        $post_id = null;
        if ($post_id = DB::table('post_table')->insertGetId([
            'USER_ID' => Session::get('soundjam_user'),
            'PRODUCT_ID' => 1,
            'TITLE' => $product,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            'AUDIO1' => 'storage/music/' . $mp3_name,
            'AUDIO2' => null,
            'IMAGES' => 'storage/product/' . $img_name,
            'POST_TYPE' => 0,
        ])) {
            Log::debug('自由成功');
        } else {
            Log::debug('自由失敗');
        }

        //連結投稿データの数を取得
        $count = (int)$request->input('connectCounter');
        Log::debug((int)$count);

        //連結投稿の数だけデータを取得
        for ($i = 0; $i < $count; $i++) {

            //タイトル
            $title = $request->input('connectFree' . $i . '_1');
            //概要
            $overview = $request->input('connectFree' . $i . '_2');

            //音声ファイルの名前を取得
            $audio1 = $request->file('connectFree' . $i . '_3')->getClientOriginalName();
            //音声データをstorage/app/public/productに保存
            $request->file('connectFree' . $i . '_3')->storeAs('public/music', $audio1);

            //画像ファイルの名前を取得
            $images = $request->file('connectFree' . $i . '_4')->getClientOriginalName();
            //画像データをstorage/app/public/productに保存
            $request->file('connectFree' . $i . '_4')->storeAs('public/product', $audio1);

            //連結投稿データを格納する
            if (DB::table('connected_post_table')->insert([
                //連結元のID
                'SOURCE_POST_ID' => $post_id,
                //タイトル
                'TITLE' => $title,
                //概要
                'OVERVIEW' => $overview,
                //音声
                'AUDIO1' => 'storage/music/' . $audio1,
                //画像
                'IMAGES' => 'storage/product/' . $images,
            ])) {
                Log::debug('連結投稿成功');
            } else {
                Log::debug('連結投稿失敗');
                return '連結投稿失敗';
            };
        }
    }

    //　レビュー投稿をDBに登録
    public function editReview(Request $request)
    {

        //　音声ファイル名取得
        $mp3_1_name = $request->file('mp3_1')->getClientOriginalName();
        $mp3_2_name = $request->file('mp3_2')->getClientOriginalName();
        // storage/app/public/musicに、ファイルを保存
        $request->file('mp3_1')->storeAs('public/music', $mp3_1_name);
        $request->file('mp3_2')->storeAs('public/music', $mp3_2_name);

        //　画像ファイル名取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/public/productに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        //レビュー投稿データを取得
        $product = $request->input('product');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');

        //挿入するデータのID取得用変数
        $post_id = null;

        //レビュー投稿データをDBに格納
        if ($post_id = DB::table('post_table')->insertGetId([
            'USER_ID' => Session::get('soundjam_user'),
            'PRODUCT_ID' => 1,
            'TITLE' => $product,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            // publicの中のリンクを書くと表示される
            'AUDIO1' => 'storage/music/' . $mp3_1_name,
            'AUDIO2' => 'storage/music/' . $mp3_2_name,
            'IMAGES' => 'storage/product/' . $img_name,
            'POST_TYPE' => 1,
        ])) {
            Log::debug('レビュー投稿成功');
        } else {
            Log::debug('レビュー投稿失敗');
        }

        //連結投稿データの数を取得
        $count = (int)$request->input('connectCounter');
        Log::debug((int)$count);

        //連結投稿の数だけデータを取得
        for ($i = 0; $i < $count; $i++) {
            // Log::debug($i);
            // Log::debug($request->input('connectReview' . $i . '_1'));
            // Log::debug($request->input('connectReview' . $i . '_2'));
            // Log::debug($request->file('connectReview' . $i . '_3')->getClientOriginalName());
            // Log::debug($request->file('connectReview' . $i . '_4')->getClientOriginalName());

            //タイトル
            $title = $request->input('connectReview' . $i . '_1');
            //概要
            $overview = $request->input('connectReview' . $i . '_2');

            //音声ファイルの名前を取得
            $audio1 = $request->file('connectReview' . $i . '_3')->getClientOriginalName();
            //音声データをstorage/app/public/productに保存
            $request->file('connectReview' . $i . '_3')->storeAs('public/music', $audio1);

            //画像ファイルの名前を取得
            $images = $request->file('connectReview' . $i . '_4')->getClientOriginalName();
            //画像データをstorage/app/public/productに保存
            $request->file('connectReview' . $i . '_4')->storeAs('public/product', $audio1);

            //連結投稿データを格納する
            if (DB::table('connected_post_table')->insert([
                //連結元のID
                'SOURCE_POST_ID' => $post_id,
                //タイトル
                'TITLE' => $title,
                //概要
                'OVERVIEW' => $overview,
                //音声
                'AUDIO1' => 'storage/music/' . $audio1,
                //画像
                'IMAGES' => 'storage/product/' . $images,
            ])) {
                Log::debug('連結投稿成功');
            } else {
                Log::debug('連結投稿失敗');
                return '連結投稿失敗';
            };
        }
    }

    // お問い合わせ処理
    public function question(Request $request)
    {
        $title = $request->input('title');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');


        if (DB::table('inquiry_table')->insert([
            'PRODUCT_ID' => null,
            'REPLY_FROM' => 1,
            'REPLY_TO' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => null,
            'AUDIO1' => null,
            'AUDIO2' => null,
            'IMAGES' => null,
            'IDENTIFICATION' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
        // 'REPLY_FROM' ここはユーザーIDを引っ張ってくる予定,
        // IDENTIFICATION →問い合わせ１，申請０
    }

    // 申請処理
    public function application(Request $request)
    {

        //画像ファイル取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        // 音声ファイルの名前取得
        $music_OFF_name = $request->file('OFF')->getClientOriginalName();
        $request->file('OFF')->storeAs('public/music', $music_OFF_name);

        $music_ON_name = $request->file('ON')->getClientOriginalName();
        $request->file('ON')->storeAs('public/music', $music_ON_name);

        $title = $request->input('title');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');
        if (DB::table('inquiry_table')->insert([
            'PRODUCT_ID' => 1,
            'REPLY_FROM' => 1,
            'REPLY_TO' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'AUDIO1' => 'storage/music/' . $music_OFF_name,
            'AUDIO2' => 'storage/music/' . $music_ON_name,
            'IMAGES' => 'storage/product/' . $img_name,
            'IDENTIFICATION' => 0,
        ])) {
            Log::debug('プロモ成功');
        } else {
            Log::debug('プロモ失敗');
        }
        // 'REPLY_FROM' ここはユーザーIDを引っ張ってくる予定,
        // IDENTIFICATION →問い合わせ１，申請０
    }


    /*
    ===============================ログイン認証処理======================================
    */
    // session情報取得
    public function get_session()
    {
        return Session::get('soundjam_user');
    }

    // ユーザー情報取得
    public function get_user(Request $request)
    {
        DB::select('SELECT * FROM user_table WHERE id=' . $request);
    }

    // ログイン
    public function login(Request $request)
    {
        // 引数に指定したセッションデータを削除
        Session::forget("soundjam_user");
        //　strpos:指定した文字列が見つかる位置を返す
        if (strpos($request["loginID"], '@')) {
            // メールアドレスでログイン
            $user = DB::select("SELECT * FROM user_table WHERE EMAIL_ADDRESS='" . $request["loginID"] . "'");
            //デバッグ
            Log::debug($user);
            $user[0] = (array)$user[0];
            if ($user[0]["PASSWORDS"] == $request["loginPass"]) {
                Session::put('soundjam_user', $user[0]["id"]);
            }
        } else {
            // ログインIDでログイン
            $user = DB::select('SELECT * FROM user_table WHERE ID=' . $request["loginID"]);
            $user[0] = (array)$user[0];
            if ($user[0]["PASSWORDS"] == $request["loginPass"]) {
                Session::put('soundjam_user', $user[0]["id"]);
            }
        }
        Log::debug((Session::all()));
        return Session::all();
    }

    // ログアウト
    public function logout()
    {
        Session::forget('soundjam_user');
    }

    //使用機材登録
    // public function createEquip(Request $request)
    // {
    //     //ログインユーザーのIDを取得
    //     $loginUserId = Session::get('soundjam_user');
    //     //
    //     $user = DB::select('SELECT * FROM post_table WHERE USER_ID=' . $loginUserId);
    // }
}

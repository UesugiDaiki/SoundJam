<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    // 投稿全件取得
    public function get_posts()
    {
        $posts = [];
        // 投稿データ取得 (id列の値を基準に昇順)
        $tmp_posts = DB::select('SELECT * FROM post_table ORDER BY id DESC');
        foreach ($tmp_posts as $post) {
            $items = [];

            $items2 = [];
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
            if ($post["POST_TYPE"] == 1) {
                // 製品名
                $product_name = DB::select('SELECT NAME FROM product_table WHERE id=' . $post["PRODUCT_ID"]);
                foreach ($product_name as $value) {
                    $post_key[] = 'PRODUCT_NAME';
                    $value = (array)$value;
                    $post_value[] = $value["NAME"];
                }
            }
            // 使用機材
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id=' . $post["id"]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;
            Log::debug('アイテム↓');
            Log::debug($items);

            // 連結投稿データ取得
            $test = DB::select('SELECT TITLE, OVERVIEW, AUDIO1, IMAGES FROM connected_post_table WHERE SOURCE_POST_ID=' . $post["id"]);
            foreach ($test as $item) {
                $item = (array)$item;
                $items2[] = [$item["TITLE"], $item["OVERVIEW"], $item["AUDIO1"], $item["IMAGES"]];
            }
            $post_key[] = 'CONNECT';
            $post_value[] = $items2;
            Log::debug('アイテム↓');
            Log::debug($items2);

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
    public function post_free(Request $request)
    {
        //　ファイル名取得
        $mp3_name = $request->file('mp3')->getClientOriginalName();
        $img_name = $request->file('img')->getClientOriginalName();

        $title = $request->input('title');
        $overview = $request->input('overview');
        $recording_method = $request->input('recordingMethod');
        // $equips = $request->except(['title', 'overview', 'recordingMethod', 'mp3', 'img']);

        // 使用機材のDB挿入が成功か
        $success_flg = true;

        // （消したら連結投稿出来ない）投稿したデータの主キー（id）を格納する変数
        $connect_post_id = null;
        $login_user_id = Session::get('soundjam_user');
        Log::debug('ユーザID：' . $login_user_id);
        // post_tableへの挿入
        if ($connect_post_id = DB::table('post_table')->insertGetId([
            //ログインしているユーザーのidを取得して格納
            'USER_ID' => $login_user_id,
            'PRODUCT_ID' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recording_method,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            'AUDIO1' => 'storage/music/' . $mp3_name,
            'AUDIO2' => null,
            'IMAGES' => 'storage/product/' . $img_name,
            'POST_TYPE' => 0,
        ])) {
            // postのidを取得
            // $post_id = DB::select('SELECT LAST_INSERT_ID()');
            // $post_id = (array)$post_id[0];
            // $post_id = $post_id['LAST_INSERT_ID()'];
            Log::debug('投稿id' . $connect_post_id);
            Log::debug($request->input('equip0'));

            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3')->storeAs('public/post/'.$connect_post_id .'/', $mp3_name);
            $request->file('img')->storeAs('public/post/'.$connect_post_id .'/', $img_name);

            $i = 0;
            $j = 1;
            $equips = (int)$request->input('equipsCounter');
            Log::debug('機材数：' . $equips);
            while ($i < $equips and $success_flg) {
                // $equip = $equips['equip' . $i];
                if (!(empty($request->input('equip' . $i)))) {
                    // equip_tableへの挿入
                    Log::debug($request->input('equip' . $i));
                    $success_flg = DB::table('equip_table')->insert([
                        'POST_ID' => $connect_post_id,
                        'NUMBERS' => $j,
                        'EQUIP_NAME' => $request->input('equip' . $i),
                    ]);
                    $j++;
                }
                $i++;
            }

            //＝＝＝＝＝＝＝＝＝＝＝＝連結投稿部分：消すと連結出来ません＝＝＝＝＝＝＝＝＝＝＝＝＝
            //連結投稿データの数を取得
            $count = (int)$request->input('connectCounter');
            Log::debug((int)$count);
            //連結投稿の数だけデータを取得
            for ($i = 0; $i < $count; $i++) {
                //タイトル
                $title = $request->input('connectFree' . $i . '_1');
                //概要
                $overview = $request->input('connectFree' . $i . '_2');
                //ファイル名取得
                $audio1 = $request->file('connectFree' . $i . '_3')->getClientOriginalName();
                $images = $request->file('connectFree' . $i . '_4')->getClientOriginalName();
                // storage/app/public/post/投稿IDに、ファイルを保存
                $request->file('connectFree' . $i . '_3')->storeAs('public/post/'.$connect_post_id .'/', $audio1);
                $request->file('connectFree' . $i . '_4')->storeAs('public/post/'.$connect_post_id .'/', $images);

                //連結投稿データを格納する
                if (DB::table('connected_post_table')->insert([
                    //連結元のID
                    'SOURCE_POST_ID' => $connect_post_id,
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
                }
            }
            //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        } else {
            Log::debug("失敗してます");
        }
    }

    //　レビュー投稿をDBに登録
    public function editReview(Request $request)
    {
        //　ファイル名取得
        $mp3_name1 = $request->file('mp3_1')->getClientOriginalName();
        $mp3_name2 = $request->file('mp3_2')->getClientOriginalName();
        $img_name = $request->file('img')->getClientOriginalName();

        $title = $request->input('product');
        $overview = $request->input('overview');
        $recording_method = $request->input('recordingMethod');
        // $equips = $request->except(['title', 'overview', 'recordingMethod', 'mp3', 'img']);

        // 使用機材のDB挿入が成功か
        $success_flg = true;

        // （消したら連結投稿出来ない）投稿したデータの主キー（id）を格納する変数
        $connect_post_id = null;
        $login_user_id = Session::get('soundjam_user');
        Log::debug('ユーザID：' . $login_user_id);
        // post_tableへの挿入
        if ($connect_post_id = DB::table('post_table')->insertGetId([
            //ログインしているユーザーのidを取得して格納
            'USER_ID' => $login_user_id,
            'PRODUCT_ID' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recording_method,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            'AUDIO1' => 'storage/music/' . $mp3_name1,
            'AUDIO2' => 'storage/music/' . $mp3_name2,
            'IMAGES' => 'storage/product/' . $img_name,
            'POST_TYPE' => 1,
        ])) {
            Log::debug('投稿id' . $connect_post_id);
            Log::debug($request);

            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3_1')->storeAs('public/post/'.$connect_post_id, $mp3_name1);
            $request->file('mp3_2')->storeAs('public/post/'.$connect_post_id, $mp3_name2);
            $request->file('img')->storeAs('public/post/'.$connect_post_id, $img_name);

            $i = 0;
            $j = 1;
            $equips = (int)$request->input('equipsCounter');
            Log::debug('機材数：' . $equips);
            while ($i < $equips and $success_flg) {
                // $equip = $equips['equip' . $i];
                if (!(empty($request->input('equip' . $i)))) {
                    // equip_tableへの挿入
                    Log::debug($request->input('equip' . $i));
                    $success_flg = DB::table('equip_table')->insert([
                        'POST_ID' => $connect_post_id,
                        'NUMBERS' => $j,
                        'EQUIP_NAME' => $request->input('equip' . $i),
                    ]);
                    $j++;
                }
                $i++;
            }

            //＝＝＝＝＝＝＝＝＝＝＝連結投稿部分：消すと連結出来ません＝＝＝＝＝＝＝＝＝＝＝＝＝＝
            //連結投稿データの数を取得
            $count = (int)$request->input('connectCounter');
            Log::debug((int)$count);
            //連結投稿の数だけデータを取得
            for ($i = 0; $i < $count; $i++) {
                //タイトル
                $title = $request->input('connectReview' . $i . '_1');
                //概要
                $overview = $request->input('connectReview' . $i . '_2');
                //音声ファイルの名前を取得
                $audio1 = $request->file('connectReview' . $i . '_3')->getClientOriginalName();
                $images = $request->file('connectReview' . $i . '_4')->getClientOriginalName();

                //音声データをstorage/app/public/productに保存
                $request->file('connectReview' . $i . '_3')->storeAs('public/post/'.$connect_post_id .'/', $audio1);
                $request->file('connectReview' . $i . '_4')->storeAs('public/post/'.$connect_post_id .'/', $images);
                //連結投稿データを格納する
                if (DB::table('connected_post_table')->insert([
                    //連結元のID
                    'SOURCE_POST_ID' => $connect_post_id,
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
                }
            }
            //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        } else {
            Log::debug("失敗してます");
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

    //全ユーザのアカウント情報を取得
    public function getAccount()
    {
        //全アカウント情報を取得
        // $allAccount = DB::select('SELECT id, USER_NAME, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table ORDER BY id DESC');
        // Log::debug((array)$allAccount);

        $posts = [];
        foreach (DB::select('SELECT id, USER_NAME, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table ORDER BY id DESC') as $post) {
            // オブジェクト -> 連想配列
            $post = (array)$post;
            //デバッグ
            Log::debug($post);
            //posts配列に連想配列をプッシュ
            array_push($posts, $post);
        }
        Log::debug($posts);
        return $posts;
    }

    /*
    ===============================ログイン認証処理======================================
    */
    // session情報取得
    public function get_session()
    {
        return Session::get('soundjam_user');
    }

    //ユーザー情報更新
    public function updateUser(Request $request)
    {
        //デバッグ
        Log::debug($request);
        Log::debug($request->input('icon'));

        //画像名格納変数
        $icon_name = null;
        //アイコン画像変更フラグ
        $icon_change = null;

        // 画像が変更されていない場合は、そのままパスを取得
        if (is_string($request->input('icon'))) {
            $icon_name = mb_substr($request->input('icon'), 13);
            $icon_change = false;
        } else {
            //そうでない場合は、新しい画像のデータから名前を取得
            $icon_name =  $request->file('icon')->getClientOriginalName();
            $icon_change = true;
        }
        //updateを実行
        if (DB::update('UPDATE user_table SET USER_NAME = ?, PROFILES = ?, WEBSITE = ?, ICON = ?  WHERE id = ?',  [$request->input('name'), $request->input('profiles'), $request->input('website'), 'storage/icon/' . $icon_name, Session::get('soundjam_user')])) {

            //アイコンが変更しているか判定
            if ($icon_change) {
                //変更した画像のデータを保存
                $request->file('icon')->storeAs('public/icon', $icon_name);
                return '成功（画像変更あり）';
            } else {
                return '成功（画像変更なし）';
            }
        } else {
            return '失敗';
        };
    }

    // ユーザー情報取得
    public function get_user(Request $request)
    {

        Log::debug($request['userId']);
        $post = DB::select('SELECT * FROM user_table WHERE id=' . $request['userId']);
        // オブジェクト -> 連想配列
        $post = (array)$post;
        //配列の中のオブジェクト　-> 連想配列
        $post = (array)$post[0];
        Log::debug($post);
        //ユーザの情報を返す
        return $post;
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

    // ユーザーの投稿データ取得
    public function getUserPostData(Request $request)
    {
        $posts = [];
        // 投稿データ取得 (id列の値を基準に昇順)
        $tmp_posts = DB::select('SELECT * FROM post_table WHERE USER_ID=' . $request["userId"]);
        foreach ($tmp_posts as $post) {
            //使用機材、連結投稿格納
            $items = [];
            $items2 = [];
            // 1投稿ずつのJSON整形

            // オブジェクト -> 連想配列
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            // ユーザー情報
            $user = DB::select('SELECT id, USER_NAME, PROFILES, WEBSITE, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table WHERE id=' . $request["userId"]);
            foreach ($user as $value) {
                $post_key[] = 'id';
                $post_key[] = 'USER_NAME';
                $post_key[] = 'PROFILES';
                $post_key[] = 'WEBSITE';
                $post_key[] = 'ICON';
                $post_key[] = 'FOLLOW_NOTICE';
                $post_key[] = 'LIKE_NOTICE';
                $post_key[] = 'FROZEN';
                $value = (array)$value;
                $post_value[] = $value['id'];
                $post_value[] = $value['USER_NAME'];
                $post_value[] = $value['PROFILES'];
                $post_value[] = $value['WEBSITE'];
                $post_value[] = $value['ICON'];
                $post_value[] = $value['FOLLOW_NOTICE'];
                $post_value[] = $value['LIKE_NOTICE'];
                $post_value[] = $value['FROZEN'];
            }

            //レビュー投稿の場合
            if ($post["POST_TYPE"] == 1) {
                // 製品名
                $product_name = DB::select('SELECT NAME FROM product_table WHERE id=' . $post["PRODUCT_ID"]);
                foreach ($product_name as $value) {
                    $post_key[] = 'PRODUCT_NAME';
                    $value = (array)$value;
                    $post_value[] = $value["NAME"];
                }
            }
            // 使用機材
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id=' . $post["id"]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;
            Log::debug('アイテム↓');
            Log::debug($items);

            // 連結投稿データ取得
            $test = DB::select('SELECT TITLE, OVERVIEW, AUDIO1, IMAGES FROM connected_post_table WHERE SOURCE_POST_ID=' . $post["id"]);
            foreach ($test as $item) {
                $item = (array)$item;
                $items2[] = [$item["TITLE"], $item["OVERVIEW"], $item["AUDIO1"], $item["IMAGES"]];
            }
            $post_key[] = 'CONNECT';
            $post_value[] = $items2;
            Log::debug('アイテム↓');
            Log::debug($items2);

            $post = array_combine($post_key, $post_value);

            array_push($posts, $post);
        };

        Log::debug('ループ終了');
        Log::debug($posts);
        return $posts;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use DateTime;


// 投稿関連
class PostController extends Controller
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

    //　自由投稿をDBに登録
    public function post_free(Request $request)
    {
        //　ファイル名取得
        $mp3_name = $request->file('mp3')->getClientOriginalName();
        $img_name = $request->file('img')->getClientOriginalName();

        $title = $request->input('title');
        $overview = $request->input('overview');
        $recording_method = $request->input('recordingMethod');
        date_default_timezone_set('Asia/Tokyo');
        $date_time = new DateTime();
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
            'DATES' => $date_time->format('Y-m-j G:i'),
            'LIKES' => 0,
            'AUDIO1' => $mp3_name,
            'AUDIO2' => null,
            'IMAGES' => $img_name,
            'POST_TYPE' => 0,
        ])) {
            // postのidを取得
            // $post_id = DB::select('SELECT LAST_INSERT_ID()');
            // $post_id = (array)$post_id[0];
            // $post_id = $post_id['LAST_INSERT_ID()'];
            Log::debug('投稿id' . $connect_post_id);
            Log::debug($request->input('equip0'));

            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3')->storeAs('public/post/' . $connect_post_id . '/', $mp3_name);
            $request->file('img')->storeAs('public/post/' . $connect_post_id . '/', $img_name);

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
                $request->file('connectFree' . $i . '_3')->storeAs('public/post/' . $connect_post_id . '/', $audio1);
                $request->file('connectFree' . $i . '_4')->storeAs('public/post/' . $connect_post_id . '/', $images);

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
    public function post_review(Request $request)
    {
        //　ファイル名取得
        $mp3_name1 = $request->file('mp3_1')->getClientOriginalName();
        $mp3_name2 = $request->file('mp3_2')->getClientOriginalName();
        $img_name = $request->file('img')->getClientOriginalName();

        $title = $request->input('product');
        $overview = $request->input('overview');
        $recording_method = $request->input('recordingMethod');
        $date_time = new DateTime();
        // $equips = $request->except(['title', 'overview', 'recordingMethod', 'mp3', 'img']);

        // 使用機材のDB挿入が成功か
        $success_flg = true;

        // （消したら連結投稿出来ない）投稿したデータの主キー（id）を格納する変数
        $connect_post_id = null;
        $login_user_id = Session::get('soundjam_user');
        Log::debug('ユーザID：' . $login_user_id);
        $dateTime = now();
        $dateTime = Carbon::parse( $dateTime )->timezone('Asia/Tokyo'); 
        // post_tableへの挿入
        if ($connect_post_id = DB::table('post_table')->insertGetId([
            //ログインしているユーザーのidを取得して格納
            'USER_ID' => $login_user_id,
            'PRODUCT_ID' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recording_method,
            'DATES' => $date_time->format('Y-m-j G:i'),
            'LIKES' => 0,
            'AUDIO1' => $mp3_name1,
            'AUDIO2' => $mp3_name2,
            'IMAGES' => $img_name,
            'POST_TYPE' => 1,
        ])) {
            Log::debug('投稿id' . $connect_post_id);
            Log::debug($request);

            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3_1')->storeAs('public/post/' . $connect_post_id, $mp3_name1);
            $request->file('mp3_2')->storeAs('public/post/' . $connect_post_id, $mp3_name2);
            $request->file('img')->storeAs('public/post/' . $connect_post_id, $img_name);

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
                $request->file('connectReview' . $i . '_3')->storeAs('public/post/' . $connect_post_id . '/', $audio1);
                $request->file('connectReview' . $i . '_4')->storeAs('public/post/' . $connect_post_id . '/', $images);
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

    // 引数に指定したIDのユーザ情報、投稿データ等を取得
    public function get_user_post_data(Request $request)
    {
        //全ての投稿関連データを格納する配列
        $posts = [];

        // 投稿データ取得 (id列の値を基準に昇順)
        $tmp_posts = DB::select('SELECT * FROM post_table WHERE USER_ID=' . $request["userId"]);

        //取得した投稿データを一列ずつ取り出す
        foreach ($tmp_posts as $post) {
            // 使用機材配列
            $items = [];
            // 連結投稿配列
            $items2 = [];

            // 投稿データを整形
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            //　ユーザーの情報を取得　id,
            $user = DB::select('SELECT USER_NAME, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table WHERE id=' . $request["userId"]);
            foreach ($user as $value) {
                // $post_key[] = 'id';
                $post_key[] = 'USER_NAME';
                // $post_key[] = 'PROFILES';
                // $post_key[] = 'WEBSITE';
                $post_key[] = 'ICON';
                $post_key[] = 'FOLLOW_NOTICE';
                $post_key[] = 'LIKE_NOTICE';
                $post_key[] = 'FROZEN';
                $value = (array)$value;
                // $post_value[] = $value['id'];
                $post_value[] = $value['USER_NAME'];
                // $post_value[] = $value['PROFILES'];
                // $post_value[] = $value['WEBSITE'];
                $post_value[] = $value['ICON'];
                $post_value[] = $value['FOLLOW_NOTICE'];
                $post_value[] = $value['LIKE_NOTICE'];
                $post_value[] = $value['FROZEN'];
            }

            //レビュー投稿の場合
            if ($post["POST_TYPE"] == 1) {
                // 製品名を取得
                $product_name = DB::select('SELECT NAME FROM product_table WHERE id=' . $post["PRODUCT_ID"]);
                foreach ($product_name as $value) {
                    $post_key[] = 'PRODUCT_NAME';
                    $value = (array)$value;
                    $post_value[] = $value["NAME"];
                }
            }

            // 取得した投稿IDに関連する使用機材を取得
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id=' . $post["id"]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;
            Log::debug('アイテム↓');
            Log::debug($items);

            // 取得した投稿データに関連する連結投稿データ取得
            $test = DB::select('SELECT TITLE, OVERVIEW, AUDIO1, IMAGES FROM connected_post_table WHERE SOURCE_POST_ID=' . $post["id"]);
            foreach ($test as $item) {
                $item = (array)$item;
                $items2[] = [$item["TITLE"], $item["OVERVIEW"], $item["AUDIO1"], $item["IMAGES"]];
            }
            $post_key[] = 'CONNECT';
            $post_value[] = $items2;
            Log::debug('アイテム↓');
            Log::debug($items2);

            //配列に変換
            $post = array_combine($post_key, $post_value);

            //配列$postsに格納
            array_push($posts, $post);
        };

        Log::debug('ループ終了');
        Log::debug($posts);
        return $posts;
    }
}

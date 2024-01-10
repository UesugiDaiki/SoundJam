<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use DateTime;


// 投稿関連
class PostController extends Controller
{
    // 投稿取得（タイムライン）
    public function get_posts()
    {
        // ログインしているか
        $login_user_id = Session::get('soundjam_user');
        $posts = [];

        if ($login_user_id == '') {
            // ログインしていない場合
            // 投稿データ取得 (DATES列の値を基準に降順)
            $tmp_posts = DB::select('SELECT * FROM post_table WHERE IS_PROMOTION != 1 ORDER BY DATES DESC LIMIT 30');
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
                $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id = ?', [$post["USER_ID"]]);
                foreach ($user as $value) {
                    $post_key[] = 'USER_NAME';
                    $post_key[] = 'ICON';
                    $value = (array)$value;
                    $post_value[] = $value["USER_NAME"];
                    $post_value[] = $value["ICON"];
                }
                // 使用機材
                $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id = ?', [$post["id"]]);
                foreach ($tmp_items as $item) {
                    $item = (array)$item;
                    $items[] = $item["EQUIP_NAME"];
                }
                $post_key[] = 'ITEMS';
                $post_value[] = $items;

                $post = array_combine($post_key, $post_value);

                array_push($posts, $post);
            };
        } else {
            // ログインしている場合（フォローしているユーザーの投稿のみ表示）
            $followees = [$login_user_id];
            $get_post_sql = 'SELECT * FROM post_table WHERE IS_PROMOTION != 1 AND USER_ID in (?';
            $tmp_followees = DB::select('SELECT FOLLOWEE_ID FROM follow_table WHERE FOLLOWER_ID = ?', [$login_user_id]);
            // １人以上フォローしている場合
            foreach($tmp_followees as $followee) {
                $followee = (array)$followee;
                array_push($followees, $followee['FOLLOWEE_ID']);
                $get_post_sql .= ', ?';
            }
            $get_post_sql .= ') ORDER BY DATES DESC LIMIT 30';

            $tmp_posts = DB::select($get_post_sql, $followees);
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
                $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id = ?', [$post["USER_ID"]]);
                foreach ($user as $value) {
                    $post_key[] = 'USER_NAME';
                    $post_key[] = 'ICON';
                    $value = (array)$value;
                    $post_value[] = $value["USER_NAME"];
                    $post_value[] = $value["ICON"];
                }
                // 使用機材
                $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id = ?', [$post["id"]]);
                foreach ($tmp_items as $item) {
                    $item = (array)$item;
                    $items[] = $item["EQUIP_NAME"];
                }
                $post_key[] = 'ITEMS';
                $post_value[] = $items;

                $post = array_combine($post_key, $post_value);

                array_push($posts, $post);
            };
        }

        return $posts;
    }

    // 投稿取得（投稿詳細）
    public function get_post_detail(Request $request)
    {
        // 投稿データ取得
        $tmp_posts = DB::select('SELECT * FROM post_table WHERE id = ?', [$request->input('postId')]);
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
            $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id = ?', [$post["USER_ID"]]);
            foreach ($user as $value) {
                $post_key[] = 'USER_NAME';
                $post_key[] = 'ICON';
                $value = (array)$value;
                $post_value[] = $value["USER_NAME"];
                $post_value[] = $value["ICON"];
            }
            // 使用機材
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id = ?', [$post["id"]]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;

            $post = array_combine($post_key, $post_value);
        };

        return $post;
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

        // 使用機材のDB挿入が成功か
        $success_flg = true;

        // 投稿したデータの主キー（id）を格納する変数
        $connect_post_id = null;
        $login_user_id = Session::get('soundjam_user');
        // post_tableへの挿入
        if ($connect_post_id = DB::table('post_table')->insertGetId([
            //ログインしているユーザーのidを取得して格納
            'USER_ID' => $login_user_id,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recording_method,
            'DATES' => $date_time->format('Y-m-j G:i'),
            'AUDIO1' => $mp3_name,
            'IMAGES' => $img_name,
            'POST_TYPE' => 0,
            'IS_PROMOTION' => 0,
        ])) {
            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3')->storeAs('public/post/' . $connect_post_id . '/', $mp3_name);
            $request->file('img')->storeAs('public/post/' . $connect_post_id . '/', $img_name);

            $i = 0;
            $j = 1;
            $equips = (int)$request->input('equipsCounter');
            while ($i < $equips and $success_flg) {
                // $equip = $equips['equip' . $i];
                if (!(empty($request->input('equip' . $i)))) {
                    // equip_tableへの挿入
                    $success_flg = DB::table('equip_table')->insert([
                        'POST_ID' => $connect_post_id,
                        'NUMBERS' => $j,
                        'EQUIP_NAME' => $request->input('equip' . $i),
                    ]);
                    $j++;
                }
                $i++;
            }
        }
    }

    //　レビュー投稿をDBに登録
    public function post_review(Request $request)
    {
        //　ファイル名取得
        $mp3_name1 = $request->file('mp3_1')->getClientOriginalName();
        $img_name = $request->file('img')->getClientOriginalName();

        $title = $request->input('product');
        $overview = $request->input('overview');
        $recording_method = $request->input('recordingMethod');
        date_default_timezone_set('Asia/Tokyo');
        $date_time = new DateTime();

        // 使用機材のDB挿入が成功か
        $success_flg = true;

        // 投稿したデータの主キー（id）を格納する変数
        $connect_post_id = null;
        $login_user_id = Session::get('soundjam_user');
        $dateTime = now();
        $dateTime = Carbon::parse($dateTime)->timezone('Asia/Tokyo');
        // post_tableへの挿入
        if ($connect_post_id = DB::table('post_table')->insertGetId([
            //ログインしているユーザーのidを取得して格納
            'USER_ID' => $login_user_id,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recording_method,
            'DATES' => $date_time->format('Y-m-j G:i'),
            'AUDIO1' => $mp3_name1,
            'IMAGES' => $img_name,
            'POST_TYPE' => 1,
            'IS_PROMOTION' => 0,
        ])) {
            // storage/app/public/post/投稿IDに、ファイルを保存
            $request->file('mp3_1')->storeAs('public/post/' . $connect_post_id, $mp3_name1);
            $request->file('img')->storeAs('public/post/' . $connect_post_id, $img_name);

            $i = 0;
            $j = 1;
            $equips = (int)$request->input('equipsCounter');
            while ($i < $equips and $success_flg) {
                // $equip = $equips['equip' . $i];
                if (!(empty($request->input('equip' . $i)))) {
                    // equip_tableへの挿入
                    $success_flg = DB::table('equip_table')->insert([
                        'POST_ID' => $connect_post_id,
                        'NUMBERS' => $j,
                        'EQUIP_NAME' => $request->input('equip' . $i),
                    ]);
                    $j++;
                }
                $i++;
            }
        }
    }

    // 引数に指定したIDのユーザ情報、投稿データ等を取得
    public function get_user_post_data(Request $request)
    {
        //全ての投稿関連データを格納する配列
        $posts = [];

        // 投稿データ取得 (DATES列の値を基準に昇順)
        $tmp_posts = DB::select('SELECT * FROM post_table WHERE IS_PROMOTION != 1 AND USER_ID = ? ORDER BY DATES DESC LIMIT 30', [$request->input("userId")]);

        //取得した投稿データを一列ずつ取り出す
        foreach ($tmp_posts as $post) {
            // 使用機材配列
            $items = [];

            // 投稿データを整形
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            //　ユーザーの情報を取得　id,
            $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id = ?', [$request->input("userId")]);
            foreach ($user as $value) {
                // $post_key[] = 'id';
                $post_key[] = 'USER_NAME';
                // $post_key[] = 'PROFILES';
                // $post_key[] = 'WEBSITE';
                $post_key[] = 'ICON';
                $value = (array)$value;
                // $post_value[] = $value['id'];
                $post_value[] = $value['USER_NAME'];
                // $post_value[] = $value['PROFILES'];
                // $post_value[] = $value['WEBSITE'];
                $post_value[] = $value['ICON'];
            }

            // 取得した投稿IDに関連する使用機材を取得
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id = ?', [$post["id"]]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;

            //配列に変換
            $post = array_combine($post_key, $post_value);

            //配列$postsに格納
            array_push($posts, $post);
        };

        return $posts;
    }

    // 投稿削除
    public function delete_post(Request $request)
    {
        $post_id = $request->input('postId');
        Storage::deleteDirectory('public/post/' . $post_id);
        DB::delete('DELETE FROM post_table WHERE id = ?', [$post_id]);
    }
}

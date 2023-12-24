<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// 検索関連
class SearchController extends Controller
{
    // 「いいね」検索
    public function search_like(Request $request)
    {
        $search_words = $request->input("searchWords");
        $param = [];
        for ($i = 0; $i < 3; $i++) {
            foreach ($search_words as $word) {
                $param[] = '%' . $word . '%';
            }
        }
        $param[] = $request->input("like") * 10;
        $like_results = [];

        $sql = "SELECT * FROM post_table WHERE ";
        // TITLE列から部分一致
        $i = 0;
        foreach ($search_words as $word) {
            if ($i == 0) {
                $sql .= "( TITLE LIKE ?";
            } else {
                $sql .= " AND TITLE LIKE ?";
            }
            $i++;
        }
        $sql .= " ) OR ";
        // OVERVIEW列から部分一致
        $j = 0;
        foreach ($search_words as $word) {
            if ($j == 0) {
                $sql .= "( OVERVIEW LIKE ?";
            } else {
                $sql .= " AND OVERVIEW LIKE ?";
            }
            $j++;
        }
        $sql .= " ) OR ";
        // RECORDING_METHOD列から部分一致
        $k = 0;
        foreach ($search_words as $word) {
            if ($k == 0) {
                $sql .= "( RECORDING_METHOD LIKE ?";
            } else {
                $sql .= " AND RECORDING_METHOD LIKE ?";
            }
            $k++;
        }
        $sql .= " ) ORDER BY LIKES DESC, DATES DESC LIMIT 10 OFFSET ?";
        $tmp_like_results = DB::select($sql, $param);

        // 投稿ごとにユーザー、いいね、使用機材、連結投稿の情報を追加して整形
        foreach ($tmp_like_results as $post) {
            $items = [];

            $items2 = [];
            // 1投稿ずつのJSON整形

            // オブジェクト -> 連想配列
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            //ログインしている場合
            if ($sessions = Session::get('soundjam_user', 'default') !== 'default') {
                // 自分が良いねしている投稿の場合
                if (DB::select('SELECT * FROM like_table WHERE POST_ID = ? AND LIKER_ID = ?', [$post['id'], $sessions])) {
                    //いいねフラグをtrueで送信
                    $post_key[] = 'LIKE_FLG';
                    $post_value[] = true;
                } else {
                    //いいねフラグをfalseで送信
                    $post_key[] = 'LIKE_FLG';
                    $post_value[] = false;
                };
            }

            //投稿のいいね数を計測
            // $like_list = null;
            $like_counter = 0;
            if ($like_list = DB::select('SELECT * FROM like_table WHERE POST_ID = ?', [$post['id']])) {
                foreach ($like_list as $value) {
                    //いいね数追加
                    $like_counter++;
                }
                $post_key[] = 'LIKE_COUNT';
                $post_value[] = $like_counter;
            } else {
                $post_key[] = 'LIKE_COUNT';
                $post_value[] = $like_counter;
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

            // 連結投稿データ取得
            $test = DB::select('SELECT TITLE, OVERVIEW, AUDIO1, IMAGES FROM connected_post_table WHERE SOURCE_POST_ID = ?', [$post["id"]]);
            foreach ($test as $item) {
                $item = (array)$item;
                $items2[] = [$item["TITLE"], $item["OVERVIEW"], $item["AUDIO1"], $item["IMAGES"]];
            }
            $post_key[] = 'CONNECT';
            $post_value[] = $items2;

            $post = array_combine($post_key, $post_value);

            array_push($like_results, $post);
        };

        return $like_results;
    }
    
    // 「最新」検索
    public function search_newest(Request $request)
    {
        $search_words = $request->input("searchWords");
        $param = [];
        for ($i = 0; $i < 3; $i++) {
            foreach($search_words as $word) {
                $param[] = '%' . $word . '%';
            }
        }
        $param[] = $request->input("newest") * 10;
        $newest_results = [];

        $sql = "SELECT * FROM post_table WHERE ";
        // TITLE列から部分一致
        $i = 0;
        foreach ($search_words as $word) {
            if ($i == 0) {
                $sql .= "( TITLE LIKE ?";
            } else {
                $sql .= " AND TITLE LIKE ?";
            }
            $i++;
        }
        $sql .= " ) OR ";
        // OVERVIEW列から部分一致
        $j = 0;
        foreach ($search_words as $word) {
            if ($j == 0) {
                $sql .= "( OVERVIEW LIKE ?";
            } else {
                $sql .= " AND OVERVIEW LIKE ?";
            }
            $j++;
        }
        $sql .= " ) OR ";
        // RECORDING_METHOD列から部分一致
        $k = 0;
        foreach ($search_words as $word) {
            if ($k == 0) {
                $sql .= "( RECORDING_METHOD LIKE ?";
            } else {
                $sql .= " AND RECORDING_METHOD LIKE ?";
            }
            $k++;
        }
        $sql .= " ) ORDER BY DATES DESC LIMIT 10 OFFSET ?";
        $tmp_newest_results = DB::select($sql, $param);

        // 投稿ごとにユーザー、いいね、使用機材、連結投稿の情報を追加して整形
        foreach ($tmp_newest_results as $post) {
            $items = [];

            $items2 = [];
            // 1投稿ずつのJSON整形

            // オブジェクト -> 連想配列
            $post = (array)$post;
            foreach ($post as $key => $value) {
                $post_key[] = $key;
                $post_value[] = $value;
            }

            //ログインしている場合
            if ($sessions = Session::get('soundjam_user', 'default') !== 'default') {
                // 自分が良いねしている投稿の場合
                if (DB::select('SELECT * FROM like_table WHERE POST_ID = ? AND LIKER_ID = ?', [$post['id'], $sessions])) {
                    //いいねフラグをtrueで送信
                    $post_key[] = 'LIKE_FLG';
                    $post_value[] = true;
                } else {
                    //いいねフラグをfalseで送信
                    $post_key[] = 'LIKE_FLG';
                    $post_value[] = false;
                };
            }

            //投稿のいいね数を計測
            // $like_list = null;
            $like_counter = 0;
            if ($like_list = DB::select('SELECT * FROM like_table WHERE POST_ID = ?', [$post['id']])) {
                foreach ($like_list as $value) {
                    //いいね数追加
                    $like_counter++;
                }
                $post_key[] = 'LIKE_COUNT';
                $post_value[] = $like_counter;
            } else {
                $post_key[] = 'LIKE_COUNT';
                $post_value[] = $like_counter;
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

            // 連結投稿データ取得
            $test = DB::select('SELECT TITLE, OVERVIEW, AUDIO1, IMAGES FROM connected_post_table WHERE SOURCE_POST_ID = ?', [$post["id"]]);
            foreach ($test as $item) {
                $item = (array)$item;
                $items2[] = [$item["TITLE"], $item["OVERVIEW"], $item["AUDIO1"], $item["IMAGES"]];
            }
            $post_key[] = 'CONNECT';
            $post_value[] = $items2;

            $post = array_combine($post_key, $post_value);

            array_push($newest_results, $post);
        };

        return $newest_results;
    }

    // 「アカウント」検索
    public function search_user(Request $request)
    {
        $search_words = $request->input("searchWords");
        $param = [];
        foreach ($search_words as $word) {
            $param[] = '%' . $word . '%';
        }
        $param[] = $request->input("user") * 10;

        $sql = "SELECT * FROM user_table WHERE ";
        // USER_NAME列から部分一致
        $i = 0;
        foreach ($search_words as $word) {
            if ($i == 0) {
                $sql .= "( USER_NAME LIKE ?";
            } else {
                $sql .= " AND USER_NAME LIKE ?";
            }
            $i++;
        }
        $sql .= " ) LIMIT 10 OFFSET ?";
        $user_results = DB::select($sql, $param);

        return $user_results;
    }
}

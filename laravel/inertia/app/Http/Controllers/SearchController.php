<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// 検索関連
class SearchController extends Controller
{
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
        $sql .= " ) ORDER BY DATES ASC LIMIT 30 OFFSET ?";
        $tmp_newest_results = DB::select($sql, $param);

        // 投稿ごとにユーザー、使用機材を追加して整形
        foreach ($tmp_newest_results as $post) {
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
        $sql .= " ) LIMIT 30 OFFSET ?";
        $user_results = DB::select($sql, $param);

        return $user_results;
    }
}

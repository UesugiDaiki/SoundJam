<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// 検索関連
class SearchController extends Controller
{
    // 「すべて」検索
    public function search_all(Request $request) {

    }

    // 「いいね」検索
    public function search_like(Request $request) {

    }
    

    // 「最新」検索
    public function search_newest(Request $request) {
        $search_words = $request->input("searchWords");
        $newest_offset = $request->input("newest") * 10;
        Log::debug($newest_offset);

        $sql = "SELECT * FROM post_table WHERE ";
        // TITLE列から部分一致
        $i = 0;
        foreach ($search_words as $word) {
            if ($i == 0) {
                $sql .= "( TITLE LIKE '%" . $word;
            } else {
                $sql .= "%' AND TITLE LIKE '%" . $word;
            }
            $i++;
        }
        $sql .= "%' ) OR ";
        // OVERVIEW列から部分一致
        $j = 0;
        foreach ($search_words as $word) {
            if ($j == 0) {
                $sql .= "( OVERVIEW LIKE '%" . $word;
            } else {
                $sql .= "%' AND OVERVIEW LIKE '%" . $word;
            }
            $j++;
        }
        $sql .= "%' ) OR ";
        // RECORDING_METHOD列から部分一致
        $k = 0;
        foreach ($search_words as $word) {
            if ($k == 0) {
                $sql .= "( RECORDING_METHOD LIKE '%" . $word;
            } else {
                $sql .= "%' AND RECORDING_METHOD LIKE '%". $word;
            }
            $k++;
        }
        $sql .= "%' ) ORDER BY DATES DESC LIMIT 10 OFFSET " . $newest_offset;
        Log::debug($sql);
        $newest_results = DB::select($sql);

        return $newest_results;
    }

    // 「製品」検索
    public function search_product(Request $request) {

    }

    // 「アカウント」検索
    public function search_user(Request $request) {

    }
}

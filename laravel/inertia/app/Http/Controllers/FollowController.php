<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use DateTime;

// ユーザ関連
class FollowController extends Controller
{
    // ログインしているユーザーが表示しているユーザーをフォローしているか
    public function get_follow(Request $request)
    {
        try {
            $login_account_id = $request->input('loginAccountId');
            $user_id = $request->input('userId');

            $followed = DB::select('SELECT FOLLOWER_ID, FOLLOWEE_ID FROM follow_table WHERE FOLLOWER_ID = ? AND FOLLOWEE_ID = ?', [$login_account_id, $user_id]);
            return !empty($followed);
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // フォロー
    public function follow(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Tokyo');
            $date_time = new DateTime();
            $login_account_id = $request->input('loginAccountId');
            $user_id = $request->input('userId');
            DB::insert('INSERT INTO follow_table (FOLLOWER_ID, FOLLOWEE_ID, DATES) VALUES (?, ?, ?)', [$login_account_id, $user_id, $date_time->format('Y-m-j G:i')]);
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // フォロー解除
    public function un_follow(Request $request)
    {
        try {
            $login_account_id = $request->input('loginAccountId');
            $user_id = $request->input('userId');
            DB::delete('DELETE FROM follow_table WHERE FOLLOWER_ID = ? AND FOLLOWEE_ID = ?', [$login_account_id, $user_id]);
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }
}

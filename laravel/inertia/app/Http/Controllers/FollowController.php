<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

// ユーザ関連
class FollowController extends Controller
{
    // ログインしているユーザーが表示しているユーザーをフォローしているか
    public function get_follow(Request $request)
    {
        $login_account_id = $request->input('loginAccountId');
        $user_id = $request->input('userId');

        $followed = DB::select('SELECT FOLLOWER_ID, FOLLOWEE_ID FROM follow_table WHERE FOLLOWER_ID = ? AND FOLLOWEE_ID = ?', [$login_account_id, $user_id]);
        return !empty($followed);
    }

    // フォロー
    public function follow(Request $request)
    {
        $login_account_id = $request->input('loginAccountId');
        $user_id = $request->input('userId');
        DB::insert('INSERT INTO follow_table (FOLLOWER_ID, FOLLOWEE_ID) VALUES (?, ?)', [$login_account_id, $user_id]);
    }

    // フォロー解除
    public function un_follow(Request $request)
    {
        $login_account_id = $request->input('loginAccountId');
        $user_id = $request->input('userId');
        DB::delete('DELETE FROM follow_table WHERE FOLLOWER_ID = ? AND FOLLOWEE_ID = ?', [$login_account_id, $user_id]);
    }
}

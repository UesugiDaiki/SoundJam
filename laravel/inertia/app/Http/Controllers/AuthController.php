<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

/* ログイン、ログアウト、新規登録など　認証機能関連 */

class AuthController extends Controller
{
    // session情報取得
    public function get_session()
    {
        return Session::get('soundjam_user');
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
}

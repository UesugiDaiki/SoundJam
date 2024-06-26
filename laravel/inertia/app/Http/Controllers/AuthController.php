<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/* ログイン、ログアウト、新規登録など　認証機能関連 */

class AuthController extends Controller
{
    // session情報取得
    public function get_session()
    {
        try {
            return Session::get('soundjam_user');
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // ログイン
    public function login(Request $request)
    {
        try {
            // 引数に指定したセッションデータを削除
            Session::forget("soundjam_user");
            //　strpos:指定した文字列が見つかる位置を返す
            if (strpos($request["loginID"], '@')) {
                // メールアドレスでログイン
                $user = DB::select('SELECT * FROM user_table WHERE EMAIL_ADDRESS = ?', [$request->input("loginID")]);
                //デバッグ
                $user = (array)$user[0];
                if ($user["PASSWORDS"] == $request["loginPass"]) {
                    Session::put('soundjam_user', $user["id"]);
                } else {
                    return [false];
                }
            } else {
                // ログインIDでログイン
                $user = DB::select('SELECT * FROM user_table WHERE ID = ?', [$request->input("loginID")]);
                $user = (array)$user[0];
                if ($user["PASSWORDS"] == $request["loginPass"]) {
                    Session::put('soundjam_user', $user["id"]);
                } else {
                    return [false];
                }
            }
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }

        return Session::all();
    }

    // ログアウト
    public function logout()
    {
        try {
            Session::forget('soundjam_user');
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // 新規登録
    public function regist(Request $request)
    {
        try {
            // DB追加
            $regist_data = [
                'USER_NAME' => $request->input("registName"),
                'PROFILES' => '',
                'WEBSITE' => '',
                'ICON' => 'default_icon.jpg',
                'EMAIL_ADDRESS' => $request->input("registMail"),
                'PASSWORDS' => $request->input("registPass"),
            ];
            $user_id = DB::table('user_table')->insertGetId($regist_data);

            // ユーザーディレクトリ作成
            Storage::makeDirectory('public/user/' . $user_id);
            Storage::copy('public/user/default_icon.jpg', 'public/user/' . $user_id . '/default_icon.jpg');
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }
}

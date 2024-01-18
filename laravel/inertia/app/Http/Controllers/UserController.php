<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Mockery\Undefined;

// ユーザ関連
class UserController extends Controller
{

    //全ユーザのアカウント情報を取得
    public function get_account()
    {
        //全アカウント情報を取得
        $posts = [];
        foreach (DB::select('SELECT id, USER_NAME, ICON FROM user_table ORDER BY id DESC LIMIT 30') as $post) {
            // オブジェクト -> 連想配列
            $post = (array)$post;
            //posts配列に連想配列をプッシュ
            array_push($posts, $post);
        }
        return $posts;
    }

    //ユーザー情報更新
    public function update_user(Request $request)
    {
        // 画像名格納変数
        $icon_name = null;
        // アイコン画像変更フラグ
        $icon_change = null;
        // webサイトurl格納
        $web_url = null;
        // プロフィール格納
        $profile = null;
        $id = $request->input('id');

        // 画像が変更されていない場合は、そのままアイコン名を取得
        if (is_string($request->input('icon'))) {
            $icon_name = $request->input('icon');
            $icon_change = false;
        } else {
            // そうでない場合は、新しい画像のデータから名前を取得
            $icon_name =  $request->file('icon')->getClientOriginalName();
            $icon_change = true;
        }
        // webサイトのURLが設定してない場合,空文字を挿入
        if ($request->input('website') === null) {
            $web_url = "";
        } else {
            $web_url = $request->input('website');
        }

        // webサイトのURLが設定してない場合,空文字を挿入
        if ($request->input('profiles') === null) {
            $profile = "";
        } else {
            $profile = $request->input('profiles');
        }

        //updateを実行
        if (DB::update('UPDATE user_table SET USER_NAME = ?, PROFILES = ?, WEBSITE = ?, ICON = ?  WHERE id = ?',  [$request->input('name'), $profile, $web_url, $icon_name, Session::get('soundjam_user')])) {
            //アイコンが変更しているか判定
            if ($icon_change) {
                // 変更したアイコン画像をユーザのフォルダに保存
                $request->file('icon')->storeAs('public/user/' . $id, $icon_name);
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
        $post = DB::select('SELECT * FROM user_table WHERE id = ?', [$request->input('userId')]);
        // オブジェクト -> 連想配列
        $post = (array)$post;
        //配列の中のオブジェクト　-> 連想配列
        $post = (array)$post[0];
        //ユーザの情報を返す
        return $post;
    }

    // パスワード変更
    public function reset_pass(Request $request)
    {
        $before_pass = $request->input('beforePass');
        $new_pass = $request->input('newPass');
        $login_user_id = Session::get('soundjam_user');
        $user = DB::select('SELECT PASSWORDS FROM user_table WHERE id = ?', [$login_user_id]);
        $user_pass = (array)$user[0];
        $user_pass = $user_pass['PASSWORDS'];
        if ($before_pass == $user_pass) {
            DB::update('UPDATE user_table set PASSWORDS = ? WHERE id = ?', [$new_pass, $login_user_id]);
            return 'success';
        } else {
            return 'incorrect';
        }
    }
}

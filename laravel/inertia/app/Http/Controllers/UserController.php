<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

// ユーザ関連
class UserController extends Controller
{

    //全ユーザのアカウント情報を取得
    public function get_account()
    {
        //全アカウント情報を取得
        // $allAccount = DB::select('SELECT id, USER_NAME, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table ORDER BY id DESC');
        // Log::debug((array)$allAccount);

        $posts = [];
        foreach (DB::select('SELECT id, USER_NAME, ICON, FOLLOW_NOTICE, LIKE_NOTICE, FROZEN FROM user_table ORDER BY id DESC') as $post) {
            // オブジェクト -> 連想配列
            $post = (array)$post;
            //デバッグ
            Log::debug($post);
            //posts配列に連想配列をプッシュ
            array_push($posts, $post);
        }
        Log::debug($posts);
        return $posts;
    }

    //ユーザー情報更新
    public function update_user(Request $request)
    {
        //デバッグ
        Log::debug($request);
        Log::debug($request->input('icon'));

        //画像名格納変数
        $icon_name = null;
        //アイコン画像変更フラグ
        $icon_change = null;

        // 画像が変更されていない場合は、そのままパスを取得
        if (is_string($request->input('icon'))) {
            $icon_name = mb_substr($request->input('icon'), 13);
            $icon_change = false;
        } else {
            //そうでない場合は、新しい画像のデータから名前を取得
            $icon_name =  $request->file('icon')->getClientOriginalName();
            $icon_change = true;
        }
        //updateを実行
        if (DB::update('UPDATE user_table SET USER_NAME = ?, PROFILES = ?, WEBSITE = ?, ICON = ?  WHERE id = ?',  [$request->input('name'), $request->input('profiles'), $request->input('website'), 'storage/icon/' . $icon_name, Session::get('soundjam_user')])) {

            //アイコンが変更しているか判定
            if ($icon_change) {
                //変更した画像のデータを保存
                $request->file('icon')->storeAs('public/icon', $icon_name);
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

        Log::debug($request['userId']);
        $post = DB::select('SELECT * FROM user_table WHERE id=' . $request['userId']);
        // オブジェクト -> 連想配列
        $post = (array)$post;
        //配列の中のオブジェクト　-> 連想配列
        $post = (array)$post[0];
        Log::debug($post);
        //ユーザの情報を返す
        return $post;
    }
}

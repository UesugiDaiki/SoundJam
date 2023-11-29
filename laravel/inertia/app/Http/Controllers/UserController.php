<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class UserController extends Controller
{
    // 投稿全件取得
    public function get_posts(){
        $posts = [];
        $tmp_posts = DB::select('SELECT * FROM post_table');
        foreach ($tmp_posts as $post) {
            $items = [];
            // 1投稿ずつのJSON整形

            // オブジェクト -> 連想配列
            $post = (array)$post;
            foreach($post as $key => $value){
                $post_key[] = $key;
                $post_value[] = $value;
            }

            // ユーザー名
            $user = DB::select('SELECT USER_NAME, ICON FROM user_table WHERE id='.$post["USER_ID"]);
            foreach($user as $value){
                $post_key[] = 'USER_NAME';
                $post_key[] = 'ICON';
                $value = (array)$value;
                $post_value[] = $value["USER_NAME"];
                $post_value[] = $value["ICON"];
            }
            // 製品名
            $product_name = DB::select('SELECT NAME FROM product_table WHERE id='.$post["PRODUCT_ID"]);
            foreach($product_name as $value){
                $post_key[] = 'PRODUCT_NAME';
                $value = (array)$value;
                $post_value[] = $value["NAME"];
            }
            // 使用機材
            $tmp_items = DB::select('SELECT EQUIP_NAME FROM equip_table WHERE post_id='.$post["id"]);
            foreach ($tmp_items as $item) {
                $item = (array)$item;
                $items[] = $item["EQUIP_NAME"];
            }
            $post_key[] = 'ITEMS';
            $post_value[] = $items;

            $post = array_combine($post_key, $post_value);

            array_push($posts, $post);
        };

        return $posts;
    }

    // ユーザー情報取得
    public function get_user(Request $request) {
        DB::select('SELECT * FROM user_table WHERE id='.$request);
    }

    // ログイン
    public function login(Request $request) {
        Session::forget("soundjam_user");
        if (strpos($request["loginID"], '@')) {
            // メールアドレスでログイン
            $user = DB::select('SELECT * FROM user_table WHERE EMAIL_ADDRESS='.$request["loginID"]);
            if ($user[0]["PASSWORDS"] == $request["loginPass"]) {
                Session::put('soundjam_user', $user[0]["id"]);
            }
        } else {
            // ログインIDでログイン
            $user = DB::select('SELECT * FROM user_table WHERE ID='.$request["loginID"]);
            $user[0] = (array)$user[0];
            if ($user[0]["PASSWORDS"] == $request["loginPass"]) {
                Session::put('soundjam_user', $user[0]["id"]);
            }
        }
        return Session::all();
    }

    //　自由投稿をDBの投稿テーブルに登録
    public function postcreate(Request $request)
    {
        // formDataから値を取得

        //　音声ファイル名取得
        $mp3_name = $request->file('mp3')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('mp3')->storeAs('public/product', $mp3_name);

        //　画像ファイル名取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');


        if (DB::table('post_table')->insert([
            'USER_ID' => 1,
            'PRODUCT_ID' => 1,
            'TITLE' => $product,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            'AUDIO1' => $mp3_name,
            'AUDIO2' => null,
            'IMAGES' => $img_name,
            'POST_TYPE' => 2,
            'SOURCE_POST_ID' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
    }
    //　レビュー投稿をDBの投稿テーブルに登録
    public function editReview(Request $request)
    {
        // formDataから値を取得

        //　音声ファイル名取得
        $mp3_1_name = $request->file('mp3_1')->getClientOriginalName();
        $mp3_2_name = $request->file('mp3_2')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('mp3_1')->storeAs('public/product', $mp3_1_name);
        $request->file('mp3_2')->storeAs('public/product', $mp3_2_name);

        //　画像ファイル名取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');


        if (DB::table('post_table')->insert([
            'USER_ID' => 1,
            'PRODUCT_ID' => 1,
            'TITLE' => $product,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'DATES' => '2023/11/29',
            'LIKES' => 0,
            'AUDIO1' => $mp3_1_name,
            'AUDIO2' => $mp3_2_name,
            'IMAGES' => $img_name,
            'POST_TYPE' => 1,
            'SOURCE_POST_ID' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
    
    // session情報取得
    public function get_session() {
        return Session::get('soundjam_user');
    }

    // ログアウト
    public function logout() {
        Session::forget("soundjam_user");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    // public function get_user(Request $request) {
    //     DB::select('SELECT * ')
    // }

    //　製品データをDBの製品テーブルに登録
    public function product(Request $request)
    {
        // formDataから値を取得
        //　ファイル名取得
        $file_name = $request->file('file')->getClientOriginalName();

        // storage/app/publicに、ファイルを保存
        $request->file('file')->storeAs('public/product', $file_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        // Log::debug($request->file('file'));
        // Log::debug($product);
        // Log::debug($overview);

        if (DB::table('product_table')->insert([
            'name' => $product,
            'image' => $file_name,
            'overview' => $overview,
            'temp_regist' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
    }
}

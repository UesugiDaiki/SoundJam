<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


//製品関連
class ProductController extends Controller
{
    //　製品データをDBの製品テーブルに登録
    public function create_product(Request $request)
    {
        //　ファイル名取得
        $file_name = $request->file('file')->getClientOriginalName();

        // storage/app/publicに、画像ファイルを保存
        $request->file('file')->storeAs('public/product', $file_name);

        $product = $request->input('product');
        $overview = $request->input('overview');
        // Log::debug($request->file('file'));
        // Log::debug($product);
        // Log::debug($overview);

        if (DB::table('product_table')->insert([
            'name' => $product,
            'image' => 'storage/product/' . $file_name,
            'overview' => $overview,
            'temp_regist' => 1,
        ])) {
            Log::debug('成功');
        } else {
            Log::debug('失敗');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    //良いね登録
    public function createLike(Request $request)
    {
        Log::debug($request['postId']);
        DB::table('nice_table')->insert([
            //ログインユーザ
            'LIKER_ID' => Session::get('soundjam_user'),
            //投稿ID
            'POST_ID' => $request['postId'],
        ]);
    }

    //良いね解除
    public function deleteLike(Request $request)
    {
        Log::debug($request['postId']);
        DB::delete('DELETE FROM nice_table WHERE LIKER_ID =' . Session::get('soundjam_user') . ' AND POST_ID = ' . $request['postId']);
    }
}

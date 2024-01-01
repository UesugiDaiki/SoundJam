<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

// 運営に対する申告、申請関連
class AppController extends Controller
{
    // お問い合わせ処理
    public function question(Request $request)
    {
        $title = $request->input('title');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');


        DB::table('inquiry_table')->insert([
            'REPLY_FROM' => Session::get('soundjam_user'),
            'REPLY_TO' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => null,
            'AUDIO1' => null,
            'IMAGES' => null,
            'IDENTIFICATION' => 1,
        ]);
        // 'REPLY_FROM' ここはユーザーIDを引っ張ってくる予定,
        // IDENTIFICATION →問い合わせ１，申請０
    }

    // 申請処理
    public function application(Request $request)
    {

        //画像ファイル取得
        $img_name = $request->file('img')->getClientOriginalName();
        // storage/app/publicに、ファイルを保存
        $request->file('img')->storeAs('public/product', $img_name);

        // 音声ファイルの名前取得
        $music_OFF_name = $request->file('OFF')->getClientOriginalName();
        $request->file('OFF')->storeAs('public/music', $music_OFF_name);

        $music_ON_name = $request->file('ON')->getClientOriginalName();
        $request->file('ON')->storeAs('public/music', $music_ON_name);

        $title = $request->input('title');
        $overview = $request->input('overview');
        $recordingMethod = $request->input('recordingMethod');
        DB::table('inquiry_table')->insert([
            'REPLY_FROM' => 1,
            'REPLY_TO' => null,
            'TITLE' => $title,
            'OVERVIEW' => $overview,
            'RECORDING_METHOD' => $recordingMethod,
            'AUDIO1' => 'storage/music/' . $music_OFF_name,
            'IMAGES' => 'storage/product/' . $img_name,
            'IDENTIFICATION' => 0,
        ]);
        // 'REPLY_FROM' ここはユーザーIDを引っ張ってくる予定,
        // IDENTIFICATION →問い合わせ１，申請０
    }

    // 運営からのメッセージ取得
    public function get_inquiry() {
        $login_user_id = Session::get('soundjam_user');
        return DB::select('SELECT TITLE, OVERVIEW FROM inquiry_table WHERE REPLY_TO = ? ORDER BY id DESC', [$login_user_id]);
    }
}

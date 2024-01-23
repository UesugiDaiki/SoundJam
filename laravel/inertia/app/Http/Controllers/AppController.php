<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use DateTime;

// 運営に対する申告、申請関連
class AppController extends Controller
{
    // お問い合わせ処理
    public function question(Request $request)
    {
        try {
            $title = $request->input('title');
            $overview = $request->input('overview');

            DB::table('inquiry_table')->insert([
                'REPLY_FROM' => Session::get('soundjam_user'),
                'REPLY_TO' => null,
                'TITLE' => $title,
                'OVERVIEW' => $overview,
            ]);
            // 'REPLY_FROM' ここはユーザーIDを引っ張ってくる予定,
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // 申請処理
    public function application(Request $request)
    {
        try {
            //　ファイル名取得
            $mp3_name = $request->file('mp3')->getClientOriginalName();
            $img_name = $request->file('img')->getClientOriginalName();

            $title = $request->input('title');
            $overview = $request->input('overview');
            $recording_method = $request->input('recordingMethod');
            date_default_timezone_set('Asia/Tokyo');
            $date_time = new DateTime();

            // 使用機材のDB挿入が成功か
            $success_flg = true;

            // 投稿したデータの主キー（id）を格納する変数
            $connect_post_id = null;
            $login_user_id = Session::get('soundjam_user');
            // post_tableへの挿入
            if ($connect_post_id = DB::table('post_table')->insertGetId([
                //ログインしているユーザーのidを取得して格納
                'USER_ID' => $login_user_id,
                'TITLE' => $title,
                'OVERVIEW' => $overview,
                'RECORDING_METHOD' => $recording_method,
                'DATES' => $date_time->format('Y-m-j G:i'),
                'AUDIO1' => $mp3_name,
                'IMAGES' => $img_name,
                'POST_TYPE' => 1,
                'IS_PROMOTION' => 1,
            ])) {
                // storage/app/public/post/投稿IDに、ファイルを保存
                $request->file('mp3')->storeAs('public/post/' . $connect_post_id . '/', $mp3_name);
                $request->file('img')->storeAs('public/post/' . $connect_post_id . '/', $img_name);

                $i = 0;
                $j = 1;
                $equips = (int)$request->input('equipsCounter');
                while ($i < $equips and $success_flg) {
                    // $equip = $equips['equip' . $i];
                    if (!(empty($request->input('equip' . $i)))) {
                        // equip_tableへの挿入
                        $success_flg = DB::table('equip_table')->insert([
                            'POST_ID' => $connect_post_id,
                            'NUMBERS' => $j,
                            'EQUIP_NAME' => $request->input('equip' . $i),
                        ]);
                        $j++;
                    }
                    $i++;
                }
            }
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }

    // 運営からのメッセージ取得
    public function get_inquiry()
    {
        try {
            $login_user_id = Session::get('soundjam_user');
            return DB::select('SELECT TITLE, OVERVIEW FROM inquiry_table WHERE REPLY_TO = ? ORDER BY id DESC', [$login_user_id]);
            // 例外キャッチャ
        } catch (\Throwable $e) {
            // エラーをlaravel.logに表示
            Log::debug($e);
            return [false];
        }
    }
}

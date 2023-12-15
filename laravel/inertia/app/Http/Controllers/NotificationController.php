<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

// 通知関連
class NotificationController extends Controller
{
    // 通知取得
    public function get_notifications()
    {
        $login_user_id = Session::get('soundjam_user');
        $login_user_settings = DB::select('SELECT FOLLOW_NOTICE, LIKE_NOTICE FROM user_table WHERE id = ?', [$login_user_id]);
        $login_user_settings = (array)$login_user_settings[0];
        $follow_notice = $login_user_settings['FOLLOW_NOTICE'];
        $like_notice = $login_user_settings['LIKE_NOTICE'];
    }

    // 投稿通知ON
    public function on_notice(Request $request)
    {
        $login_user_id = Session::get('soundjam_user');
        $user_id = $request->input('userId');
        DB::insert('INSERT INTO postnotice_table (is_on, is_truned_on) VALUES (?, ?)', [$login_user_id, $user_id]);
    }

    // 投稿通知OFF
    public function off_notice(Request $request)
    {
        $login_user_id = Session::get('soundjam_user');
        $user_id = $request->input('userId');
        DB::delete('DELETE FROM postnotice_table WHERE is_on = ? AND is_truned_on = ?', [$login_user_id, $user_id]);
    }

    // ログインしているユーザーが表示しているユーザーの通知をONにしているか
    public function get_post_notice(Request $request)
    {
        $login_user_id = Session::get('soundjam_user');
        $user_id = $request->input('userId');

        $notification = DB::select('SELECT is_on, is_truned_on FROM postnotice_table WHERE is_on = ? AND is_truned_on = ?', [$login_user_id, $user_id]);
        return !empty($notification);
    }
}

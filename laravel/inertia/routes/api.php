<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//認証関係
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/getSession', [AuthController::class, 'get_session']);
Route::post('/regist', [AuthController::class, 'regist']);

//投稿関係
Route::post('/postFree', [PostController::class, 'post_free']);
Route::post('/postReview', [PostController::class, 'post_review']);
Route::get('/getPosts', [PostController::class, 'get_posts']);
Route::post('/getUserPostData', [PostController::class, 'get_user_post_data']);

//ユーザー関連
Route::post('/updateUser', [UserController::class, 'update_user']);
//　引数に設定したidのユーザ情報を取得する
Route::post('/getUser', [UserController::class, 'get_user']);
//全ユーザーのアカウントを取得
Route::get('/getAccount', [UserController::class, 'get_account']);
// 通知設定情報取得
Route::get('/getNoticeSettings', [UserController::class, 'get_notice_settings']);
// 通知設定
Route::get('/offFollowNotice', [UserController::class, 'off_follow_notice']);
Route::get('/onFollowNotice', [UserController::class, 'on_follow_notice']);
Route::get('/offLikeNotice', [UserController::class, 'off_like_notice']);
Route::get('/onLikeNotice', [UserController::class, 'on_like_notice']);

// 運営に対する申請、申告関連
//お問い合わせ
Route::post('/question', [AppController::class, 'question']);
//プロモーション
Route::post('/application', [AppController::class, 'application']);

//いいね
Route::post('/createLike', [LikeController::class, 'createLike']);


// 製品関連
//製品登録
Route::post('/product', [ProductController::class, 'create_product']);
//全製品データを取得
// Route::get('/getProduct', [ProductController::class, 'getProduct']);

// 検索関連
Route::post('/searchAll', [SearchController::class, 'search_all']);
Route::post('/searchLike', [SearchController::class, 'search_like']);
Route::post('/searchNewest', [SearchController::class, 'search_newest']);
Route::post('/searchProduct', [SearchController::class, 'search_product']);
Route::post('/searchUser', [SearchController::class, 'search_user']);

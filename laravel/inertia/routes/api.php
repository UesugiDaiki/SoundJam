<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
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

Route::get('/hello', [HelloController::class, 'hello']);

Route::get('/getPosts', [UserController::class, 'index']);
// ���i
Route::post('/product', [UserController::class, 'product']);
// ���R���e
Route::post('/postFree', [UserController::class, 'post_free']);
// ���r���[���e
Route::post('/postReview', [UserController::class, 'editReview']);
// �₢���킹
Route::post('/question', [UserController::class, 'question']);
// �\��
Route::post('/application', [UserController::class, 'application']);

Route::get('/getPosts', [UserController::class, 'get_posts']);
Route::post('/updateUser', [UserController::class, 'updateUser']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/getSession', [UserController::class, 'get_session']);

//　引数に設定したidのユーザ情報を取得する
Route::post('/getUser', [UserController::class, 'get_user']);
// 引数に指定したユーザの情報、投稿情報の全てを取得
Route::post('/getUserPostData', [UserController::class, 'getUserPostData']);
//全ユーザーのアカウントを取得
Route::get('/getAccount', [UserController::class, 'getAccount']);
//全製品データを取得
Route::get('/getProduct', [UserController::class, 'getProduct']);

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

Route::post('/product', [UserController::class, 'product']);

Route::get('/getPosts', [UserController::class, 'get_posts']);
// Route::get('/getUser', [UserController::class, 'get_user']);


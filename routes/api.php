<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpensesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// sanctum 認証ガードを使用することにより、認証済みのユーザーのみがアクセス可能
Route::get('/user/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::get('/user/index', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/expenses/index', [ExpensesController::class, 'index'])->middleware('auth:sanctum');
Route::get('/expenses/spend/month', [ExpensesController::class, 'spend'])->middleware('auth:sanctum');
Route::get('/expenses/income/month', [ExpensesController::class, 'income'])->middleware('auth:sanctum');
Route::post('/expenses/register', [ExpensesController::class, 'register'])->middleware('auth:sanctum');

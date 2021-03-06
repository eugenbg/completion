<?php

use App\Http\Controllers\CompletionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CompletionController::class, 'index']);
Route::post('/', [CompletionController::class, 'generateText']);

Route::post('/register', [UserController::class, 'register']);
Route::get('/user-list', [UserController::class, 'listUsers']);
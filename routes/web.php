<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [ArticleController::class, 'listWelcome']);
Route::get('/articles', [ArticleController::class, 'list']);
Route::get('/articles/{id}', [ArticleController::class, 'details']);
Route::get('/articles?tag={tag_id}', [ArticleController::class, 'list']);

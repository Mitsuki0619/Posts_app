<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::resource('posts', App\Http\Controllers\PostController::class)->except('index', 'show');

Route::get('/posts/search', [App\Http\Controllers\PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

Route::resource('/users', App\Http\Controllers\UserController::class);
Route::resource('/comments', App\Http\Controllers\CommentController::class)->middleware('auth');

Route::post('posts/{post}/likes', [App\Http\Controllers\LikeController::class, 'store'])->name('likes');
Route::post('posts/{post}/unlikes', [App\Http\Controllers\LikeController::class, 'destroy'])->name('unlikes');


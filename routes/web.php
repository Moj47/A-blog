<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{post}',[PostController::class,'show'])->name('post.show')->whereNumber('post');
Route::group([],function () {
    Route::get('/create',[PostController::class,'create'])->name('admin.posts.create');
    Route::post('/store',[PostController::class,'store'])->name('admin.posts.store');
    Route::get('/posts-list',[PostController::class,'adminIndex'])->name('admin.posts.index');
});
Auth::routes();


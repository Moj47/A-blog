<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{post}',[PostController::class,'show'])->name('post.show')->whereNumber('post');
Route::group(['middleware'=>'auth' ,'prefix' => 'admin', 'as' => 'admin.'],function () {
    Route::get('/posts-list',[PostController::class,'adminIndex'])->name('posts.index');
    Route::get('/create',[PostController::class,'create'])->name('posts.create');
    Route::post('/store',[PostController::class,'store'])->name('posts.store');
    Route::get('/edit/{post}',[PostController::class,'edit'])->name('posts.edit');
    Route::put('/update/{post}',[PostController::class,'update'])->name('posts.update');
    Route::get('/delete/{post}',[PostController::class,'delete'])->name('posts.delete');

    Route::resource('/categories',CategoryController::class);
    Route::resource('/tags',TagController::class);
});
Auth::routes();


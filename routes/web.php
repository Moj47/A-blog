<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{post}',[PostController::class,'show'])->name('post.show');

Auth::routes();


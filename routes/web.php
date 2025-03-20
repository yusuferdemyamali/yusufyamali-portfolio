<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/yazilar', [BlogController::class, 'index'])->name('front.blog');
Route::get('/yazilar/{slug}', [BlogController::class, 'show'])->name('front.blog.details');


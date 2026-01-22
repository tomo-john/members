<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SandboxController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';

Route::middleware(['auth'])->group(function () {

    // Post (Laravelの教科書学習用)
    Route::resource('post', PostController::class);

    // Sand box (index(get) と store(post) だけを有効にする)
    Route::resource('sandbox', SandboxController::class)->only(['index', 'store']);

    // Dogs (単一のビュー)
    Route::view('/dogs', 'dogs')->name('dogs');
});


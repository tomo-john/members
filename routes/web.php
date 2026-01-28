<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Livewire\Sandbox;

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

    // Sand box (Livewire 2ファイル構成・コントローラなし)
    Route::get('/sandbox', Sandbox::class)->name('sandbox');

    // Dogs (Volt: 単一のビュー)
    Route::view('/dogs', 'dogs')->name('dogs');

    // Tasks (Volt: 単一のビュー)
    Route::view('/tasks', 'tasks')->name('tasks');
});


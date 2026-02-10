<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Livewire\Sandbox;
use App\Livewire\UserList;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // Post (Laravelの教科書学習用)
    Route::resource('post', PostController::class);

    // admin専用のUserList
    Route::middleware(['can:admin'])->group(function () {
        Route::get('users', UserList::class)->name('users.list');
    });

    // Sand box (Livewire 2ファイル構成・コントローラなし)
    Route::get('/sandbox', Sandbox::class)->name('sandbox');

    // Dogs (Volt: 単一のビュー)
    Route::view('/dogs', 'dogs')->name('dogs');

    // Tasks (Volt: 単一のビュー)
    Route::view('/tasks', 'tasks')->name('tasks');
});


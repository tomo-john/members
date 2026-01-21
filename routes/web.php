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
    Route::resource('post', PostController::class);
    Route::get('/sandbox', [SandboxController::class, 'index'])->name('sandbox');
    Route::post('/sandbox', [SandboxController::class, 'store'])->name('sandbox.store');
});


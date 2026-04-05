<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\User\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'ensure.approved'])->group(function () {
    Route::get('/', fn () => view('eje'));
});

Route::prefix('admin/users')
    //->middleware(['auth', 'ensure.approved'])
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/api', [UserController::class, 'api']);
    });
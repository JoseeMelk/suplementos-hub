<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Provider\ProductController;
use App\Http\Controllers\CategoryController;

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

Route::prefix('admin/')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('users', UserController::class)->only('index', 'update');
        Route::get('users/api', [UserController::class, 'api']);
    });

Route::prefix('provider/')
    ->middleware(['auth', 'ensure.approved', 'role:provider'])
    ->group(function () {
        Route::resource('products', ProductController::class)->only('index', 'store');
        Route::get('products/api', [ProductController::class, 'api']);
    });

//Rutas para admin y proveedor
Route::post('categories/api', [CategoryController::class, 'api'])->middleware('auth', 'role:admin|provider');
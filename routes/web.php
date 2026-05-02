<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Provider\ProductController;
use App\Http\Controllers\Provider\ProviderSlugController;
use App\Http\Controllers\Provider\ProviderProfileController;
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
        Route::get('users/api', [UserController::class, 'api']);
        Route::resource('users', UserController::class)->only(['index', 'update']);
    });

Route::prefix('provider/')
    ->middleware(['auth', 'ensure.approved', 'role:provider'])
    ->group(function () {
        Route::get('products/api', [ProductController::class, 'api']);
        Route::resource('products', ProductController::class)->except(['create', 'edit']);
        Route::resource('profiles', ProviderProfileController::class)->only(['index']);
        Route::resource('slugs', ProviderSlugController::class)->only(['store']);
    });

//Rutas para admin y proveedor
Route::get('categories/api', [CategoryController::class, 'api'])->middleware(['auth', 'role:admin|provider']);

// Ruta pública para catálogo de proveedores
Route::get('catalogo/{slug}', fn () => view('public.catalog'))->name('public.catalog');
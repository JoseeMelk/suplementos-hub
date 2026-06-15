<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Provider\ProductController;
use App\Http\Controllers\Provider\ProviderSlugController;
use App\Http\Controllers\Provider\ProviderProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Support\Tickets\TicketController;
use App\Http\Controllers\Support\Tickets\ConversationController;
use App\Http\Controllers\Support\Tickets\MessageController;

//Ruta publica sobre nosotros
Route::get('/', function () {
    return view('public.index');
});

//Ruta para login y registro
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
});

// Ruta para dashboard y cerrar sesion
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

//Rutas para categoria, accesible para admin y proveedor
Route::get('categories/api', [CategoryController::class, 'api'])->middleware(['auth', 'role:admin|provider']);

// Rutas públicas para catálogo de proveedores
Route::get('catalogo/{slug}', [CatalogController::class, 'index'])->name('catalogo.index');
Route::get('catalogo/{slug}/api', [CatalogController::class, 'api'])->name('catalogo.api');
Route::get('catalogo/{slug}/productos/{product}', [CatalogController::class, 'show'])->name('catalogo.show');


//Rutas para soporte
Route::prefix('api/provider')
    ->middleware(['auth', 'ensure.approved', 'role:provider'])
    ->group(function () {

        Route::post('tickets', [TicketController::class, 'store']);
        Route::get('tickets/active', [TicketController::class, 'myActiveTicket']);

        Route::get('conversations/active', [ConversationController::class, 'active']);

        // Route::get('conversations/{conversation}/messages', [MessageController::class, 'index']);
        // Route::post('conversations/{conversation}/messages', [MessageController::class, 'store']);
    });

Route::prefix('api/admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('tickets', [TicketController::class, 'index']);
        Route::patch('tickets/{ticket}', [TicketController::class, 'update']);
        Route::patch('tickets/{ticket}/close', [TicketController::class, 'close']);

        Route::get('conversations', [ConversationController::class, 'index']);
        Route::get('conversations/{conversation}', [ConversationController::class, 'show']);

        // Route::get('conversations/{conversation}/messages', [MessageController::class, 'index']);
        // Route::post('conversations/{conversation}/messages', [MessageController::class, 'store']);
    });
//Ruta para ver enviar mensajes
Route::prefix('api/conversations')
    ->middleware(['auth', 'role:admin|provider'])
    ->group(function () {
        Route::get('{conversation}/messages', [MessageController::class, 'index']);
        Route::post('{conversation}/messages', [MessageController::class, 'store']);
    });


//RUTAS RENDER SUPPORT

// PROVIDER SUPPORT
Route::prefix('provider')
    ->middleware(['auth', 'ensure.approved', 'role:provider'])
    ->group(function () {
        Route::get('support/tickets', function () {
            return view('support.provider.provider-support');
        });
    });

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('support/tickets', function () {
            return view('support.admin.admin-support');
        });
    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagfixoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CadastroPagController;
use App\Http\Controllers\CalendarioController;

Route::name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    /* Modelo de Route group *
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{item}', [UserController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{item}/update', [UserController::class, 'update'])->name('update');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
    });
    /**/

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{item}', [UserController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{item}/update', [UserController::class, 'update'])->name('update');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
    });

    Route::prefix('contas')->name('contas.')->group(function () {
        Route::get('/', [PagfixoController::class, 'index'])->name('index');
        Route::get('/{item}', [PagfixoController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [PagfixoController::class, 'edit'])->name('edit');
        Route::put('/{item}/update', [PagfixoController::class, 'update'])->name('update');
        Route::get('/create', [PagfixoController::class, 'create'])->name('create');
        Route::post('/store', [PagfixoController::class, 'store'])->name('store');
    });

    // Route::get('cadastropag', [CadastroPagController::class, 'index'])->name('cadastropag.index');
    // Route::get('calendario', [CalendarioController::class, 'index'])->name('calendario.index');
});

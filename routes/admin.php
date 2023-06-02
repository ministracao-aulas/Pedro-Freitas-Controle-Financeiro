<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CadastroPagController;

Route::name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    /* Modelo de Route group *
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{item}/show', [UserController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{item}/update', [UserController::class, 'update'])->name('update');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
    });
    /**/

    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::match([
            'post',
            'patch',
            'put',
        ], '/update', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('contas')->name('contas.')->group(function () {
        Route::get('/', [BillController::class, 'index'])->name('index');
        Route::get('/{item}/show', [BillController::class, 'show'])->name('show');
        Route::get('/{item}/edit', [BillController::class, 'edit'])->name('edit');
        Route::put('/update/{item?}', [BillController::class, 'update'])->name('update');
        Route::match(['get', 'delete'], '/destroy/{item?}', [BillController::class, 'destroy'])->name('destroy');
        Route::get('/create', [BillController::class, 'create'])->name('create');
        Route::post('/store', [BillController::class, 'store'])->name('store');
        Route::get('/wip', [BillController::class, 'wip'])->name('wip');
    });

    // Route::get('cadastropag', [CadastroPagController::class, 'index'])->name('cadastropag.index');
    // Route::get('calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    Route::any('export/{resource}/{type}', [ExportController::class, 'export'])
    ->name('resource_export')
    ->where(['resource' => ExportController::getPipedAllowedResources(),
        'type' => 'pdf|csv|xlsx',
        // 'id', '[0-9]+',
    ]);
});

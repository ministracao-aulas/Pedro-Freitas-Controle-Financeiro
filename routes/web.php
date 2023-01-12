<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOnlyController;
use Illuminate\Support\Facades\Route;

/**
 * Itens de Admin estão no arquivo de rotas 'routes/admin.php'
 */

// routes/admin.php

Route::get('/', AuthOnlyController::class)->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'auth']);
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

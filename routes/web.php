<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastroPagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\pagfixoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'auth']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('cadastropag', [CadastroPagController::class, 'index'])->name('cadastropag.index');
Route::get('pagfixo', [pagfixoController::class, 'index'])->name('pagfixo.index');
Route::post('pagfixo.insert', [pagfixoController::class, 'insert'])->name('pagfixo.insert');
Route::get('pagfixo/inserir', [pagfixoController::class, 'create'])->name('pagfixo.inserir');

Route::get('/home-admin', [AdminController::class, 'index'])->name('admin.index');
Route::put('admin/{Usuario}', [AdminController::class, 'editar'])->name('admin.editar');
Route::get('calendario', [CalendarioController::class, 'index'])->name('calendario.index');

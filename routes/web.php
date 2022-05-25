<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    //一般使用者
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::prefix('file')->group(function () {
        Route::get('/', [FileController::class, 'index']);
        Route::get('/create', [FileController::class, 'create']);
        Route::get('/edit', [FileController::class, 'edit']);
        Route::get('/changeArea', [FileController::class, 'changeArea']);
    });
    //管理者專用功能
    Route::middleware(['auth.custom'])->group(function () {
        Route::prefix('permission')->group(function () {
            Route::get('/', [PermissionController::class, 'index']);
            Route::get('/create', [PermissionController::class, 'create']);
            Route::get('/edit', [PermissionController::class, 'edit']);
        });
        Route::prefix('area')->group(function () {
            Route::get('/', [AreaController::class, 'index']);
            Route::get('/create', [AreaController::class, 'create']);
            Route::get('/edit', [AreaController::class, 'edit']);
        });
    });
});

require __DIR__ . '/auth.php';
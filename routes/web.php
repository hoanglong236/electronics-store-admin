<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// AdminController Routing
Route::group(['prefix' => 'admin'], function () {
    Route::get('', [AdminController::class, 'index']);
    Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
    Route::post('/login-handler', [AdminController::class, 'loginHandler'])->name(
        'admin.login.handler');

    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/register-handler', [AdminController::class, 'registerHandler'])->name(
        'admin.register.handler');

    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::group(['prefix' => 'catalog/brand'], function () {
    Route::get('', [BrandController::class, 'index'])->name('catalog.brand.index');
    Route::get('/create', [BrandController::class, 'create'])->name('catalog.brand.create');
    Route::post('/create-handler', [BrandController::class, 'createHandler'])->name(
        'catalog.brand.create.handler');
    Route::get('/update/{brandId}', [BrandController::class, 'update'])->name('catalog.brand.update');
    Route::put('/update-handler/{brandId}', [BrandController::class, 'updateHandler'])->name(
        'catalog.brand.update.handler');
    Route::delete('/delete/{brandId}', [BrandController::class, 'delete'])->name('catalog.brand.delete');
});

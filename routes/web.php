<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

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
Route::get('/', [AdminController::class, 'index']);
Route::get('/login', [AdminController::class, 'index']);
Route::post('/loginHandler', [AdminController::class, 'loginHandler']);
Route::get('/register',[AdminController::class, 'register']);
Route::post('/registerHandler', [AdminController::class, 'registerHandler']);
Route::post('/logout', [AdminController::class, 'logout']);


Route::get('/dashboard',[DashboardController::class, 'index']);

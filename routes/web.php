<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
    Route::post('create-user', [UserController::class, 'create'])->middleware([HandlePrecognitiveRequests::class]);
    Route::put('update-user/{id}', [UserController::class, 'update'])->middleware([HandlePrecognitiveRequests::class]);
    Route::delete('delete-user/{id}', [UserController::class, 'delete'])->middleware([HandlePrecognitiveRequests::class]);
    Route::get('logs', [WelcomeController::class, 'logs'])->name('logs');
    Route::get('export', [UserController::class, 'export'])->name('export');
});

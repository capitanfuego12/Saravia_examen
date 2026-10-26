<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\OrganizadorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:6,1')
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:6,1')
        ->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('eventos', EventoController::class)->except('show');
    Route::resource('organizadores', OrganizadorController::class)
        ->parameters(['organizadores' => 'organizador'])
        ->except('show');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

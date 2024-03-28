<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rute untuk menampilkan formulir login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Rute untuk memproses data login
Route::post('/login', [AuthController::class, 'login']);

//Rute untuk menampilkan halaman dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

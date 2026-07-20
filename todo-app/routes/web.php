<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

// مسارات الهوية (Authentication)
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// مسارات المهام المحمية (تتطلب تسجيل دخول)
Route::middleware(['firebase.auth'])->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/search', [TodoController::class, 'index'])->name('todo.search');
    Route::post('/add', [TodoController::class, 'store']);
    Route::post('/update/{id}', [TodoController::class, 'update']);
    Route::get('/delete/{id}', [TodoController::class, 'destroy']);
});
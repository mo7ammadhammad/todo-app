<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;

// مسارات الهوية (Authentication)
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['firebase.auth'])->group(function () {
    
    Route::get('/', [TodoController::class, 'index'])->name('todo.index');
    
    Route::get('/search', [TodoController::class, 'index'])->name('todo.search');
    
    // مسار إضافة مهمة جديدة (متوافق مع أكشن الـ Blade)
    Route::post('/store', [TodoController::class, 'store'])->name('todo.store');
    
    // مسار تحديث المهمة (تم تحويله إلى PATCH ليتوافق مع الـ Modal والـ Blade المدمج)
    Route::patch('/update/{id}', [TodoController::class, 'update'])->name('todo.update');
    
    // مسار حذف المهمة
    Route::get('/delete/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
});
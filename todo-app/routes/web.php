<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::get('/search', [TodoController::class, 'search'])
    ->name('todo.search');
 
Route::get('/', [TodoController::class, 'index']);

Route::post('/add', [TodoController::class, 'store']);

Route::get('/delete/{id}', [TodoController::class, 'delete']);
Route::post('/update/{id}', [TodoController::class, 'update']);

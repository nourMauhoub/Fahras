<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;


Route::get('/users', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);



Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::get('/search', [BookController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('isAdmin')->group(function () {
        Route::post('/books', [BookController::class, 'store']);
        Route::patch('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });
});


// Route::apiResource('/books', BookController::class);
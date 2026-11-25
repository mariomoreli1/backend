<?php
// ЛР15. REST API (php artisan install:api), все адреса начинаются с /api.
// signin, login, logout, article (index, show, store, update, destroy); изменение данных — под auth:sanctum.

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

// регистрация и вход
Route::post('/signin', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'authenticate']);

// новости смотреть можно всем
Route::get('/article', [ArticleController::class, 'index']);
Route::get('/article/{article}', [ArticleController::class, 'show']);

// остальное только с токеном
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/article', [ArticleController::class, 'store']);
    Route::put('/article/{article}', [ArticleController::class, 'update']);
    Route::delete('/article/{article}', [ArticleController::class, 'destroy']);
});

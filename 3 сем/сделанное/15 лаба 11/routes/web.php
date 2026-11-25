<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);

Route::get('/galery/{full_image}', [MainController::class, 'galery']);

Route::get('/about', function () {
    return view('about');
});

Route::get('/contacts', function () {
    $contacts = [
        ['name' => 'Адрес', 'value' => 'г. Москва, ул. Большая Семёновская, д. 38'],
        ['name' => 'Телефон', 'value' => '+7 (495) 223-05-23'],
        ['name' => 'Почта', 'value' => 'info@mospolytech.ru'],
        ['name' => 'Часы работы', 'value' => 'пн-пт с 9:00 до 18:00'],
    ];

    return view('contacts', ['contacts' => $contacts]);
});

// регистрация и вход
Route::get('/signin', [AuthController::class, 'create']);
Route::post('/signin', [AuthController::class, 'registration']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// только для авторизованных
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::resource('article', ArticleController::class)->except(['index', 'show']);
    Route::resource('comment', CommentController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
    Route::post('/comment/{comment}/accept', [CommentController::class, 'accept']);
    Route::post('/comment/{comment}/reject', [CommentController::class, 'reject']);
});

// смотреть новости можно всем
Route::resource('article', ArticleController::class)->only(['index', 'show']);

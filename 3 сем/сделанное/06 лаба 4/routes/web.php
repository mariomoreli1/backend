<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
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

Route::get('/signin', [AuthController::class, 'create']);
Route::post('/signin', [AuthController::class, 'registration']);

Route::get('/article', [ArticleController::class, 'index']);

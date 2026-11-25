<?php
// ЛР1. Маршруты /, /about, /contacts. Для контактов массив передаётся в view('contacts', ['contacts' => $contacts]).

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

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

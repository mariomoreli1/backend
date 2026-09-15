<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
 * ЛР2: главная страница отдаётся методом index контроллера MainController,
 * который забирает данные из public/data/news.json.
 */
Route::get('/', [MainController::class, 'index'])->name('main');

/*
 * ЛР2: страница галереи -- показывает full_image новости.
 */
Route::get('/galery/{id}', [MainController::class, 'galery'])
    ->whereNumber('id')
    ->name('galery');

/*
 * ЛР1: статическая текстовая страница.
 */
Route::get('/about', function () {
    return view('about');
})->name('about');

/*
 * ЛР1: массив данных передаётся в шаблон методом view().
 */
Route::get('/contacts', function () {
    $contacts = [
        [
            'type'  => 'Адрес',
            'value' => 'г. Москва, ул. Большая Семёновская, д. 38',
            'link'  => null,
        ],
        [
            'type'  => 'Телефон',
            'value' => '+7 (495) 223-05-23',
            'link'  => 'tel:+74952230523',
        ],
        [
            'type'  => 'E-mail',
            'value' => 'info@mospolytech.ru',
            'link'  => 'mailto:info@mospolytech.ru',
        ],
        [
            'type'  => 'Часы работы',
            'value' => 'Пн-Пт, 09:00 - 18:00',
            'link'  => null,
        ],
    ];

    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');

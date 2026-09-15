# ЛР1-ЛР2 «Серверная разработка» — сайт на Laravel

Учебный сайт: макет страниц (Blade), маршрутизация (Route) и контроллер (Controller).

## Запуск

```bash
composer install     # если папки vendor нет
cp .env.example .env # если файла .env нет
php artisan key:generate
php artisan serve
```

Сайт откроется на <http://127.0.0.1:8000>.

## Что где лежит

| Путь | Что это |
|---|---|
| `routes/web.php` | маршрутизатор: какой адрес какую страницу открывает |
| `app/Http/Controllers/MainController.php` | контроллер: читает новости из json и отдаёт в шаблон |
| `resources/views/layouts/app.blade.php` | макет-обёртка: шапка с меню + подвал с ФИО и группой |
| `resources/views/main.blade.php` | главная: приветствие + таблица новостей |
| `resources/views/about.blade.php` | страница «О нас» |
| `resources/views/contacts.blade.php` | страница «Контакты» (данные приходят массивом) |
| `resources/views/galery.blade.php` | галерея: показывает `full_image` новости |
| `public/data/news.json` | данные для главной страницы |
| `public/images/` | картинки `preview_*` и `full_*` |
| `public/css/style.css` | стили |

## Маршруты

| Метод | Адрес | Обработчик |
|---|---|---|
| GET | `/` | `MainController@index` |
| GET | `/galery/{id}` | `MainController@galery` |
| GET | `/about` | замыкание в `routes/web.php` |
| GET | `/contacts` | замыкание, передаёт массив контактов через `view()` |

## Выполнение пунктов задания

**ЛР1**

- макет (обёртка) страниц — `resources/views/layouts/app.blade.php`;
- ссылки «О нас» и «Контакты» в навигации макета;
- страница-приветствие — блок `.hero` в `main.blade.php`;
- страница «О нас» — `about.blade.php`;
- рендеринг страниц в маршрутизаторе — `routes/web.php`;
- массив данных для «Контактов» передан методом `view()`;
- «Контакты» свёрстаны с динамическим выводом этого массива (`@foreach`).

**ЛР2**

- файлы добавлены в `public` (`data/news.json`, `images/`, `css/`);
- контроллер создан командой `php artisan make:controller MainController`;
- метод `index` читает данные из json и отправляет на главную страницу;
- главная свёрстана под вывод этих данных в виде таблицы;
- маршрут `/` вызывает метод контроллера;
- `preview_image` — ссылка на страницу `galery`;
- на странице `galery` отображается `full_image`.

## Автор

Федоткин Арсений Андреевич, группа 251-321

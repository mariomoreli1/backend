<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Путь к файлу с новостями внутри папки public.
     */
    private const NEWS_FILE = 'data/news.json';

    /**
     * Читает новости из json-файла и возвращает массив.
     */
    private function getNews(): array
    {
        $path = public_path(self::NEWS_FILE);

        if (! file_exists($path)) {
            return [];
        }

        return json_decode(file_get_contents($path), true) ?? [];
    }

    /**
     * ЛР2: главная страница -- список новостей из json-файла.
     */
    public function index()
    {
        return view('main', [
            'news' => $this->getNews(),
        ]);
    }

    /**
     * ЛР2: галерея -- показывает full_image выбранной новости.
     */
    public function galery(int $id)
    {
        $news = $this->getNews();

        $item = collect($news)->firstWhere('id', $id);

        abort_if($item === null, 404);

        return view('galery', [
            'item' => $item,
        ]);
    }
}

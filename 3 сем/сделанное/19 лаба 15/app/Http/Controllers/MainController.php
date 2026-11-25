<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $articles = json_decode(file_get_contents(public_path('articles.json')), true);

        return view('main', ['articles' => $articles]);
    }

    public function galery($full_image)
    {
        return view('galery', ['full_image' => $full_image]);
    }
}

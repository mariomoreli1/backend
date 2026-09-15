<?php

class CalcController
{
    public function index()
    {
        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text      = $_POST['text'] ?? '';
            $speed     = (int)($_POST['speed'] ?? 200);
            $wordCount = str_word_count(strip_tags($text), 0, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ');
            $minutes   = $wordCount > 0 ? ceil($wordCount / $speed) : 0;
            $result    = [
                'words'   => $wordCount,
                'minutes' => $minutes,
                'speed'   => $speed,
            ];
        }

        require __DIR__ . '/tpl_calc.php';
    }
}

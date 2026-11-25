<?php
// ЛР14. Планировщик: Schedule::command('stat:send')->everyMinute(). Запуск — php artisan schedule:run.

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// статистика модераторам каждую минуту
Schedule::command('stat:send')->everyMinute();

<?php
// ЛР14. Модель просмотра страницы (таблица paths).

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// здесь хранятся просмотры статей
class Path extends Model
{
    protected $fillable = ['url', 'user_id'];
}

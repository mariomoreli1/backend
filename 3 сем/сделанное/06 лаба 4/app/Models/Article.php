<?php
# Модель связана с таблицей articles, в fillable — поля, которые можно заполнять.
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'name', 'short_desc', 'desc'];
}

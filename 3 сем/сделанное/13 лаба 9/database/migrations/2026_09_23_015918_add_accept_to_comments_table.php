<?php
// ЛР9. Поле accept (boolean, по умолчанию false): комментарий не одобрен, пока модератор его не примет.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // прошёл ли комментарий модерацию
            $table->boolean('accept')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('accept');
        });
    }
};

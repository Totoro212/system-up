<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Добавляем флаг участия тренировки в ротации программы.
     * in_rotation = true  → тренировка участвует в очереди (round-robin)
     * in_rotation = false → отдельная тренировка вне программы
     */
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->boolean('in_rotation')->default(true)->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->dropColumn('in_rotation');
        });
    }
};

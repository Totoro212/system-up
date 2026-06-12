<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Переход тренировок с привязки по дням недели на последовательную очередь.
     * Удаляем day_of_week, добавляем sort_order для определения порядка ротации.
     */
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('title');
            $table->dropColumn('day_of_week');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->string('day_of_week')->nullable()->after('title');
            $table->dropColumn('sort_order');
        });
    }
};

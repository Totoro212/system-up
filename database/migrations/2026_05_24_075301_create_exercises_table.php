<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Название упражнения
            $table->integer('sets'); // Количество подходов
            $table->string('reps'); // Количество повторений (например, "12" или "10-12" или "до отказа")
            $table->string('target_muscles')->nullable(); // Какие мышцы задействует (например, "Грудь, трицепс")
            $table->string('weight')->nullable(); // Какие веса дополнительно использовать (например, "20 кг гантели" или "собственный вес")
            $table->text('description')->nullable(); // Описание как правильно делать
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};

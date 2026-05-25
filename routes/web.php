<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestlogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Роуты с rate limiting для защиты от спама (комфортные лимиты для обычного использования)
    Route::middleware('throttle:60,1')->group(function () {
        Route::post('stoic-quotes', [DashboardController::class, 'storeStoicQuote'])->name('stoic_quotes.store');
        Route::post('quest/{id}/complete', [QuestlogController::class, 'complete'])->name('quest_complete');
        Route::post('quests', [\App\Http\Controllers\QuestController::class, 'store'])->name('quests.store');
        Route::post('quests/seed-default', [\App\Http\Controllers\QuestController::class, 'seedDefault'])->name('quests.seed_default');
        Route::post('workouts', [\App\Http\Controllers\WorkoutController::class, 'store'])->name('workouts.store');
        Route::post('workouts/seed-default', [\App\Http\Controllers\WorkoutController::class, 'seedDefault'])->name('workouts.seed_default');
        Route::post('workouts/{id}/complete', [\App\Http\Controllers\WorkoutController::class, 'complete'])->name('workouts.complete');
    });

    Route::middleware('throttle:30,1')->group(function () {
        Route::delete('quests/{id}', [\App\Http\Controllers\QuestController::class, 'destroy'])->name('quests.destroy');
        Route::delete('workouts/{id}', [\App\Http\Controllers\WorkoutController::class, 'destroy'])->name('workouts.destroy');
    });

    Route::get('workouts', [\App\Http\Controllers\WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('codex', [\App\Http\Controllers\CodexController::class, 'index'])->name('codex');
    Route::view('terminal', 'terminal')->name('terminal');
});

require __DIR__.'/auth.php';

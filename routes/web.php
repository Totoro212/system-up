<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quest\DashboardController;
use App\Http\Controllers\Quest\QuestlogController;
use App\Http\Controllers\Tools\EventController;

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
        Route::post('quests', [\App\Http\Controllers\Quest\QuestController::class, 'store'])->name('quests.store');
        Route::post('quests/seed-default', [\App\Http\Controllers\Quest\QuestController::class, 'seedDefault'])->name('quests.seed_default');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::put('events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::post('workouts', [\App\Http\Controllers\Workout\WorkoutController::class, 'store'])->name('workouts.store');
        Route::post('workouts/seed-default', [\App\Http\Controllers\Workout\WorkoutController::class, 'seedDefault'])->name('workouts.seed_default');
        Route::post('workouts/{id}/complete', [\App\Http\Controllers\Workout\WorkoutController::class, 'complete'])->name('workouts.complete');
    });

    Route::middleware('throttle:30,1')->group(function () {
        Route::delete('quests/{id}', [\App\Http\Controllers\Quest\QuestController::class, 'destroy'])->name('quests.destroy');
        Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::delete('workouts/{id}', [\App\Http\Controllers\Workout\WorkoutController::class, 'destroy'])->name('workouts.destroy');
    });

    Route::get('workouts', [\App\Http\Controllers\Workout\WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('codex', [\App\Http\Controllers\Codex\CodexController::class, 'index'])->name('codex');
    Route::get('terminal', [\App\Http\Controllers\Tools\TerminalController::class, 'index'])->name('terminal');

    // Finance Module (API endpoints for modals)
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::post('/income', [\App\Http\Controllers\Tools\FinanceController::class, 'storeIncome'])->name('income.store');
        Route::post('/expense', [\App\Http\Controllers\Tools\FinanceController::class, 'storeExpense'])->name('expense.store');
        Route::post('/transfer', [\App\Http\Controllers\Tools\FinanceController::class, 'transfer'])->name('transfer');
    });
});

require __DIR__.'/auth.php';

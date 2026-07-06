<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quest\DashboardController;
use App\Http\Controllers\Quest\QuestlogController;
use App\Http\Controllers\Quest\QuestController;
use App\Http\Controllers\Workout\WorkoutController;
use App\Http\Controllers\Tools\ToolsController;
use App\Http\Controllers\Tools\FinanceController;
use App\Http\Controllers\Tools\EventController;
use App\Http\Controllers\Tools\LifeGoalController;
use App\Http\Controllers\Codex\CodexController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    
    // ==========================================
    // ПРОФИЛЬ (Profile)
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // ОСНОВНЫЕ СТРАНИЦЫ (Views)
    // ==========================================
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Квесты
    Route::get('workouts', [WorkoutController::class, 'index'])->name('workouts.index'); // Зал
    Route::get('tools', [ToolsController::class, 'index'])->name('tools'); // Пульт
    Route::get('codex', [CodexController::class, 'index'])->name('codex'); // Кодекс

    // ==========================================
    // ДЕЙСТВИЯ (Создание / Изменение)
    // ==========================================
    Route::middleware('throttle:60,1')->group(function () {
        // Квесты
        Route::post('quest/{id}/complete', [QuestlogController::class, 'complete'])->name('quest_complete');
        Route::post('quests', [QuestController::class, 'store'])->name('quests.store');
        Route::post('quests/seed-default', [QuestController::class, 'seedDefault'])->name('quests.seed_default');
        
        // Финансы (Конверты)
        Route::post('finance/income', [FinanceController::class, 'storeIncome'])->name('finance.income.store');
        Route::post('finance/capital/adjust', [FinanceController::class, 'adjustCapital'])->name('finance.capital.adjust');
        Route::post('finance/budget/reset', [FinanceController::class, 'resetBudget'])->name('finance.budget.reset');

        // Цели и Накопления
        Route::post('finance/goals', [FinanceController::class, 'storeGoal'])->name('finance.goals.store');
        Route::post('finance/goals/{id}/add', [FinanceController::class, 'addGoalFunds'])->name('finance.goals.add');
        Route::post('finance/goals/{id}/reset', [FinanceController::class, 'resetGoalFunds'])->name('finance.goals.reset');

        // Жизненные цели
        Route::post('life-goals', [LifeGoalController::class, 'store'])->name('life-goals.store');
        Route::post('life-goals/{id}/toggle', [LifeGoalController::class, 'toggleComplete'])->name('life-goals.toggle');
        Route::post('life-goals/telegram-settings', [LifeGoalController::class, 'updateTelegramSettings'])->name('life-goals.telegram.update');
        Route::post('life-goals/telegram-test', [LifeGoalController::class, 'sendTestNotification'])->name('life-goals.telegram.test');

        // События (Пульт)
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::put('events/{id}', [EventController::class, 'update'])->name('events.update');
        
        // Тренировки
        Route::post('workouts', [WorkoutController::class, 'store'])->name('workouts.store');
        Route::post('workouts/seed-default', [WorkoutController::class, 'seedDefault'])->name('workouts.seed_default');
        Route::post('workouts/{id}/complete', [WorkoutController::class, 'complete'])->name('workouts.complete');
    });

    // ==========================================
    // ДЕЙСТВИЯ (Удаление)
    // ==========================================
    Route::middleware('throttle:30,1')->group(function () {
        Route::delete('quests/{id}', [QuestController::class, 'destroy'])->name('quests.destroy');
        Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::delete('workouts/{id}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
        Route::delete('finance/goals/{id}', [FinanceController::class, 'destroyGoal'])->name('finance.goals.destroy');
        Route::delete('life-goals/{id}', [LifeGoalController::class, 'destroy'])->name('life-goals.destroy');
    });

});

require __DIR__.'/auth.php';

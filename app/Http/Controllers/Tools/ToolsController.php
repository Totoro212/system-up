<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FinanceEnvelope;
use App\Models\FinanceTransaction;
use App\Models\LifeGoal;
use App\Models\Quest;
use App\Models\Workout;

class ToolsController extends Controller
{
    /**
     * Отобразить хаб инструментов.
     */
    public function index()
    {
        $userId = auth()->id();

        // События
        $events = Event::getUpcomingEvents($userId);

        // Конверты (Создаем по умолчанию, если их нет)
        if (FinanceEnvelope::where('user_id', $userId)->count() === 0) {
            FinanceEnvelope::insert([
                ['user_id' => $userId, 'slug' => 'needs', 'name' => '🛒 Потребности', 'percentage' => 50, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => $userId, 'slug' => 'wants', 'name' => '🎉 Желания', 'percentage' => 30, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => $userId, 'slug' => 'savings', 'name' => '🏦 Сбережения', 'percentage' => 20, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $envelopes = FinanceEnvelope::where('user_id', $userId)->get();
        
        $currentMonthStart = now()->startOfMonth();
        
        $lastReset = FinanceTransaction::where('user_id', $userId)
            ->whereNull('finance_envelope_id')
            ->where('description', 'budget_reset')
            ->latest()
            ->first();

        if ($lastReset && $lastReset->created_at > $currentMonthStart) {
            $currentMonthStart = $lastReset->created_at;
        }

        $monthlyAllocations = FinanceTransaction::where('user_id', $userId)
            ->where('type', 'income')
            ->where('created_at', '>=', $currentMonthStart)
            ->selectRaw('finance_envelope_id, sum(amount) as total')
            ->groupBy('finance_envelope_id')
            ->pluck('total', 'finance_envelope_id');

        foreach ($envelopes as $envelope) {
            $envelope->monthly_budget = $monthlyAllocations->get($envelope->id, 0);
        }

        $lifeGoals = LifeGoal::where('user_id', $userId)
            ->latest()
            ->get()
            ->sortBy(function ($goal) {
                return $goal->is_completed ? 1 : 0;
            });

        // Квесты (с проверкой выполнения за сегодня)
        $quests = Quest::where('user_id', $userId)
            ->withExists(['log' => function ($query) use ($userId) {
                $query->whereDate('created_at', today())
                      ->where('user_id', $userId);
            }])->get();

        $totalQuests = $quests->count();
        $completedQuests = $quests->where('log_exists', true)->count();

        // Сегодняшняя тренировка (round-robin ротация)
        $workouts = Workout::with('exercises')
            ->where('user_id', $userId)
            ->ordered()
            ->get();

        $nextWorkout = $workouts
            ->sortBy(function ($workout) {
                $timestamp = $workout->last_performed_at
                    ? $workout->last_performed_at->timestamp
                    : 0;
                return $timestamp + ($workout->sort_order / 10000);
            })
            ->first();

        $todayWorkout = null;
        if ($nextWorkout && !($nextWorkout->last_performed_at && $nextWorkout->last_performed_at->isToday())) {
            $todayWorkout = $nextWorkout;
        }

        return view('tools.index', [
            'events' => $events,
            'envelopes' => $envelopes,
            'lifeGoals' => $lifeGoals,
            'quests' => $quests,
            'totalQuests' => $totalQuests,
            'completedQuests' => $completedQuests,
            'todayWorkout' => $todayWorkout,
        ]);
    }
}

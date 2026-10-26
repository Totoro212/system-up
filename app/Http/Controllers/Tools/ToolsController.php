<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
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
            'quests' => $quests,
            'totalQuests' => $totalQuests,
            'completedQuests' => $completedQuests,
            'todayWorkout' => $todayWorkout,
        ]);
    }
}

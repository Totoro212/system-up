<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use App\Models\Workout;

class DashboardController extends Controller
{
    public function index()
    {
        $quests = Quest::where('user_id', auth()->id())
            ->withExists(['log' => function ($query) {
                $query->whereDate('created_at', today())
                      ->where('user_id', auth()->id());
            }])->get();
        $totalQuests = $quests->count();
        $completedQuests = $quests->where('log_exists', true)->count();

        // Получаем сегодняшнюю тренировку по round-robin логике ротации программ
        $workouts = Workout::with('exercises')
            ->where('user_id', auth()->id())
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
            
        return view('quest.index', [
            'quests' => $quests,
            'totalQuests' => $totalQuests,
            'completedQuests' => $completedQuests,
            'todayWorkout' => $todayWorkout,
        ]);
    }
}

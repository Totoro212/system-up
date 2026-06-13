<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use App\Models\Quest;

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
            
        return view('quest.index', [
            'quests' => $quests,
            'totalQuests' => $totalQuests,
            'completedQuests' => $completedQuests,
        ]);
    }
}

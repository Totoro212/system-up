<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Event;

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
        if (\App\Models\FinanceEnvelope::where('user_id', $userId)->count() === 0) {
            \App\Models\FinanceEnvelope::insert([
                ['user_id' => $userId, 'slug' => 'needs', 'name' => '🛒 Потребности', 'percentage' => 50, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => $userId, 'slug' => 'wants', 'name' => '🎉 Желания', 'percentage' => 30, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => $userId, 'slug' => 'savings', 'name' => '🏦 Сбережения', 'percentage' => 20, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $envelopes = \App\Models\FinanceEnvelope::where('user_id', $userId)->get();
        
        $savingsEnvelope = $envelopes->where('slug', 'savings')->first();
        $totalBalance = $savingsEnvelope ? $savingsEnvelope->balance : 0;

        $currentMonthStart = now()->startOfMonth();
        
        $lastReset = \App\Models\FinanceTransaction::where('user_id', $userId)
            ->whereNull('finance_envelope_id')
            ->where('description', 'budget_reset')
            ->latest()
            ->first();

        if ($lastReset && $lastReset->created_at > $currentMonthStart) {
            $currentMonthStart = $lastReset->created_at;
        }

        $monthlyAllocations = \App\Models\FinanceTransaction::where('user_id', $userId)
            ->where('type', 'income')
            ->where('created_at', '>=', $currentMonthStart)
            ->selectRaw('finance_envelope_id, sum(amount) as total')
            ->groupBy('finance_envelope_id')
            ->pluck('total', 'finance_envelope_id');

        foreach ($envelopes as $envelope) {
            $envelope->monthly_budget = $monthlyAllocations->get($envelope->id, 0);
        }

        $goals = \App\Models\FinanceGoal::where('user_id', $userId)
            ->latest()
            ->get()
            ->sortBy(function ($goal) {
                return $goal->current_amount >= $goal->target_amount ? 1 : 0;
            });

        return view('tools.index', [
            'events' => $events,
            'envelopes' => $envelopes,
            'totalBalance' => $totalBalance,
            'goals' => $goals
        ]);
    }
}

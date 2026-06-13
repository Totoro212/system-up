<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class TerminalController extends Controller
{
    /**
     * Отобразить рыночный терминал.
     */
    public function index()
    {
        // События
        $events = \App\Models\Event::getUpcomingEvents(auth()->id());

        // Финансы
        $accounts = \App\Models\Account::where('user_id', auth()->id())->get();
        $funds = \App\Models\Fund::where('user_id', auth()->id())->get();
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Сводка
        // Упрощенно: считаем общий капитал в базовой валюте (допустим UZS).
        // Если есть USD, нужно умножить на курс. Пока просто суммируем по валютам, или считаем только UZS.
        // Для простоты, выведем массивы сумм по валютам.
        $totalCapital = [];
        foreach ($accounts as $acc) {
            if (!isset($totalCapital[$acc->currency])) $totalCapital[$acc->currency] = 0;
            $totalCapital[$acc->currency] += $acc->balance;
        }

        $totalFunds = [];
        foreach ($funds as $fund) {
            // Допустим "Свободно для трат" это Нужды и Желания. Если у нас нет четкого типа, 
            // просто суммируем все балансы фондов (это и есть распределенные деньги).
            if (!isset($totalFunds[$fund->currency])) $totalFunds[$fund->currency] = 0;
            $totalFunds[$fund->currency] += $fund->balance;
        }

        return view('tools.terminal.index', [
            'events' => $events,
            'accounts' => $accounts,
            'funds' => $funds,
            'transactions' => $transactions,
            'totalCapital' => $totalCapital,
            'totalFunds' => $totalFunds
        ]);
    }
}

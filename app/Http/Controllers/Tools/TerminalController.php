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

        return view('tools.terminal.index', [
            'events' => $events,
            'accounts' => $accounts,
            'funds' => $funds
        ]);
    }
}

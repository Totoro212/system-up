<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Event;

class TerminalController extends Controller
{
    /**
     * Отобразить рыночный терминал.
     */
    public function index()
    {
        // События
        $events = Event::getUpcomingEvents(auth()->id());

        return view('tools.terminal.index', [
            'events' => $events
        ]);
    }
}

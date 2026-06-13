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

        return view('tools.terminal.index', [
            'events' => $events
        ]);
    }
}

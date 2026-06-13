<?php

namespace App\Http\Controllers\Terminal;

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
        // Логика расчета вынесена в модель Event, контроллер остается "чистым"
        $events = Event::getUpcomingEvents(auth()->id());

        return view('terminal.index', [
            'events' => $events
        ]);
    }
}

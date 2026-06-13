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
        // События
        $events = Event::getUpcomingEvents(auth()->id());

        return view('tools.index', [
            'events' => $events
        ]);
    }
}

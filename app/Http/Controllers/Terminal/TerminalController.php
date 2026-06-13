<?php

namespace App\Http\Controllers\Terminal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class TerminalController extends Controller
{
    /**
     * Отобразить рыночный терминал.
     */
    public function index()
    {
        // Загрузка и расчет событий
        $events = Event::where('user_id', auth()->id())->get()->map(function ($event) {
            $today = Carbon::today();
            $eventDate = Carbon::parse($event->event_date)->startOfDay();
            
            if ($event->is_annual) {
                // Если событие ежегодное, берем дату в текущем году
                $eventDate->year($today->year);
                
                // Если дата в этом году уже прошла, переносим на следующий год
                if ($eventDate->isPast() && !$eventDate->isToday()) {
                    $eventDate->addYear();
                }
            }
            
            $event->days_remaining = $today->diffInDays($eventDate, false);
            return $event;
        })->filter(function ($event) {
            // Убираем прошедшие неежегодные события
            return $event->days_remaining >= 0;
        })->sortBy('days_remaining')->values();

        return view('terminal.index', [
            'events' => $events
        ]);
    }
}

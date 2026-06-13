<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quest;
use App\Models\StoicQuote;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Отобразить список квестов пользователя на сегодня.
     */
    public function index()
    {
        $quests = Quest::where('user_id', auth()->id())
            ->withExists(['log' => function ($query) {
                $query->whereDate('created_at', today())
                      ->where('user_id', auth()->id());
            }])->get();
            
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
 
        return view('quest.index', [
            'quests' => $quests,
            'events' => $events
        ]);
    }

    /**
     * Создать новую стоическую цитату.
     */
    public function storeStoicQuote(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'practice' => 'nullable|string|max:5000',
        ]);

        StoicQuote::create([
            'text' => $request->text,
            'practice' => $request->practice,
        ]);

        return redirect()->back()->with('success', 'Стоическая цитата успешно добавлена в свитки!');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'is_annual',
        'icon',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_annual' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Возвращает отсортированный список предстоящих событий пользователя с расчетом дней
     */
    public static function getUpcomingEvents($userId)
    {
        return self::where('user_id', $userId)->get()->map(function ($event) {
            $today = \Carbon\Carbon::today();
            $eventDate = \Carbon\Carbon::parse($event->event_date)->startOfDay();
            
            if ($event->is_annual) {
                $eventDate->year($today->year);
                if ($eventDate->isPast() && !$eventDate->isToday()) {
                    $eventDate->addYear();
                }
            }
            
            $event->days_remaining = $today->diffInDays($eventDate, false);
            return $event;
        })->filter(function ($event) {
            return $event->days_remaining >= 0;
        })->sortBy('days_remaining')->values();
    }
}

<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Сохранить новое событие
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'icon' => 'nullable|string|max:10',
            'is_annual' => 'nullable|boolean',
        ]);

        Event::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'icon' => $validated['icon'] ?? '📅',
            'is_annual' => $request->has('is_annual'),
        ]);

        return redirect()->route('terminal')->with('success', 'Событие успешно добавлено!');
    }

    /**
     * Обновить событие
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для изменения этого события.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'icon' => 'nullable|string|max:10',
            'is_annual' => 'nullable|boolean',
        ]);

        $event->update([
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'icon' => $validated['icon'] ?? '📅',
            'is_annual' => $request->has('is_annual'),
        ]);

        return redirect()->route('terminal')->with('success', 'Событие успешно обновлено!');
    }

    /**
     * Удалить событие
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для удаления этого события.');
        }

        $event->delete();

        return redirect()->route('terminal')->with('success', 'Событие удалено!');
    }
}

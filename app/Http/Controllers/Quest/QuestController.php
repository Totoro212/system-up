<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quest;

class QuestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Quest::create([
            'title' => $validated['title'],
            'user_id' => auth()->id(),
            'type' => 'main',
        ]);

        return redirect()->route('dashboard')->with('success', 'Квест успешно добавлен!');
    }

    public function destroy($id)
    {
        $quest = Quest::findOrFail($id);

        // Убедимся, что квест принадлежит текущему пользователю или является общим системным квестом
        if ($quest->user_id !== null && $quest->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для удаления этого квеста.');
        }

        $quest->delete();

        return redirect()->route('dashboard')->with('success', 'Квест удален!');
    }

    /**
     * Загрузить 3 легендарных ежедневных квеста по умолчанию для текущего пользователя.
     */
    public function seedDefault()
    {
        $user = auth()->user();

        Quest::create([
            'title' => 'Движение тела',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        Quest::create([
            'title' => 'Deep Work (Глубокая работа)',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        Quest::create([
            'title' => 'Поглощение знаний',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        return redirect()->route('dashboard')->with('success', 'Ежедневные квесты успешно установлены!');
    }
}

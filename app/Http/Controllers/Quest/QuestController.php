<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $quest = Quest::where('user_id', auth()->id())->findOrFail($id);

        $quest->delete();

        return redirect()->route('dashboard')->with('success', 'Квест удален!');
    }

    /**
     * Загрузить 3 легендарных ежедневных квеста по умолчанию для текущего пользователя.
     */
    public function seedDefault()
    {
        $user = auth()->user();

        // Защита от дублирования: не создаём, если квесты уже есть
        if (Quest::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('info', 'Квесты уже существуют.');
        }

        DB::transaction(function () use ($user) {
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
        });

        return redirect()->route('dashboard')->with('success', 'Ежедневные квесты успешно установлены!');
    }
}


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
            'description' => 'required|string|max:5000',
        ]);

        Quest::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
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
            'description' => 'Минимум 30 минут физической активности: кардио, растяжка, прогулка быстрым шагом или тренировка. Разгони лимфу и заряди тело энергией на день.',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        Quest::create([
            'title' => 'Deep Work (Глубокая работа)',
            'description' => '90 минут работы над главным проектом или навыком в режиме абсолютного фокуса. Телефон в беззвучном режиме в другой комнате, никаких соцсетей и перебиваний.',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        Quest::create([
            'title' => 'Поглощение знаний',
            'description' => 'Чтение минимум 20 минут качественной нон-фикшн или профессиональной литературы. Зафиксируй одну мысль или идею, которую применишь на практике.',
            'user_id' => $user->id,
            'type' => 'main',
        ]);

        return redirect()->route('dashboard')->with('success', 'Ежедневные квесты успешно установлены!');
    }
}

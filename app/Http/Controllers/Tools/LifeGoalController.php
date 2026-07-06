<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LifeGoal;

class LifeGoalController extends Controller
{
    /**
     * Создать новую жизненную цель.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        LifeGoal::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_completed' => false,
        ]);

        return back()->with('success', 'Жизненная цель успешно добавлена!');
    }

    /**
     * Переключить статус выполнения жизненной цели.
     */
    public function toggleComplete($id)
    {
        $goal = LifeGoal::where('user_id', auth()->id())->findOrFail($id);
        
        $newStatus = !$goal->is_completed;
        $goal->update([
            'is_completed' => $newStatus,
            'completed_at' => $newStatus ? now() : null,
        ]);

        $message = $newStatus ? 'Цель отмечена как выполненная! 🎉' : 'Цель снова активна.';
        return back()->with('success', $message);
    }

    /**
     * Удалить жизненную цель.
     */
    public function destroy($id)
    {
        $goal = LifeGoal::where('user_id', auth()->id())->findOrFail($id);
        $goal->delete();

        return back()->with('success', 'Жизненная цель успешно удалена!');
    }
}

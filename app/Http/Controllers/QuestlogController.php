<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Questlog;
use Illuminate\Http\Request;

class QuestlogController extends Controller
{
    /**
     * Переключить статус выполнения квеста (выполнить / отменить выполнение).
     */
    public function complete($id)
    {
        // Проверяем, что квест существует и доступен текущему пользователю
        $quest = Quest::where(function ($query) {
            $query->whereNull('user_id')           // Глобальные квесты
                  ->orWhere('user_id', auth()->id()); // Личные квесты
        })->findOrFail($id);

        $existingLog = Questlog::where('quest_id', $quest->id)
            ->where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->first();

        if ($existingLog) {
            // Если сегодня уже выполняли - удаляем (отменяем)
            $existingLog->delete();
            $completed = false;
        } else {
            // Иначе - создаем
            Questlog::create(['quest_id' => $quest->id, 'user_id' => auth()->id()]);
            $completed = true;
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'completed' => $completed,
            ]);
        }

        return redirect()->back();
    }
}

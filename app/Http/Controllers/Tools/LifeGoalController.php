<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LifeGoal;
use App\Services\TelegramService;

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

    /**
     * Обновить настройки напоминаний в Telegram.
     */
    public function updateTelegramSettings(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'telegram_chat_id' => 'nullable|string|max:50',
            'telegram_reminders_enabled' => 'boolean',
            'telegram_reminders_interval' => 'required|integer|in:30,45,60,90,120',
            'telegram_reminders_start_hour' => 'required|integer|min:0|max:23',
            'telegram_reminders_end_hour' => 'required|integer|min:0|max:23',
        ]);

        // Чекбокс возвращает значение только если включен, поэтому устанавливаем значение явно
        $validated['telegram_reminders_enabled'] = $request->has('telegram_reminders_enabled');

        if ($validated['telegram_reminders_enabled'] && empty($validated['telegram_chat_id'])) {
            return back()->withErrors(['telegram_chat_id' => 'Чтобы включить оповещения, необходимо указать Telegram Chat ID.']);
        }

        $user->update($validated);

        return back()->with('success', 'Настройки Telegram успешно сохранены!');
    }

    /**
     * Отправить тестовое оповещение в Telegram.
     */
    public function sendTestNotification(TelegramService $telegramService)
    {
        $user = auth()->user();

        if (empty($user->telegram_chat_id)) {
            return back()->withErrors(['telegram_chat_id' => 'Пожалуйста, заполните и сохраните Telegram Chat ID перед проверкой.']);
        }

        $message = "🔔 <b>Тестовое оповещение</b>\n\nПривет, {$user->name}! Ваша интеграция с Telegram настроена успешно. Интервал напоминаний: {$user->telegram_reminders_interval} мин., рабочие часы: {$user->telegram_reminders_start_hour}:00 - {$user->telegram_reminders_end_hour}:00.";

        $success = $telegramService->sendMessage($user->telegram_chat_id, $message);

        if ($success) {
            return back()->with('success', 'Тестовое оповещение успешно отправлено в ваш Telegram!');
        }

        return back()->withErrors(['telegram_chat_id' => 'Не удалось отправить сообщение. Пожалуйста, убедитесь, что вы запустили вашего Telegram-бота.']);
    }
}

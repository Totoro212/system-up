<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\TelegramService;

class SendOfficeReminders extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Отправить напоминания о здоровье (вода, глаза, разминка) в Telegram по расписанию пользователя';

    /**
     * Список полезных напоминаний.
     */
    protected array $reminders = [
        "💧 <b>Время пить воду!</b>\nСделайте пару глотков чистой воды, чтобы поддерживать гидратацию организма.",
        "🚶‍♂️ <b>Пора размяться!</b>\nВстаньте из-за стола, сделайте легкую разминку плеч и шеи или пройдитесь 5 минут.",
        "👀 <b>Гимнастика для глаз!</b>\nОтведите взгляд от экрана. Посмотрите в окно или на удаленный предмет в течение 20 секунд, часто поморгайте.",
        "🧘‍♂️ <b>Проверьте осанку!</b>\nВыпрямите спину, опустите плечи, сделайте глубокий вдох и расслабьтесь.",
        "💨 <b>Дыхательная пауза!</b>\nСделайте 5 глубоких вдохов и медленных выдохов, чтобы насытить мозг кислородом.",
        "🧠 <b>Минутка отдыха!</b>\nЗакройте глаза на одну минуту и дайте голове отдохнуть от рабочих задач."
    ];

    /**
     * Выполнить консольную команду.
     */
    public function handle(TelegramService $telegramService)
    {
        // Находим пользователей с включенными уведомлениями и заполненным chat ID
        $users = User::where('telegram_reminders_enabled', true)
            ->whereNotNull('telegram_chat_id')
            ->where('telegram_chat_id', '!=', '')
            ->get();

        if ($users->isEmpty()) {
            $this->info('Нет активных пользователей с настроенными напоминаниями.');
            return;
        }

        $now = now();
        $this->info("Проверка расписания для {$users->count()} пользователей...");

        foreach ($users as $user) {
            // Проверка: рабочий ли день? (понедельник-пятница)
            if (!$now->isWeekday()) {
                $this->line("Пользователь {$user->name}: сегодня не будний день.");
                continue;
            }

            // Проверка: текущий час входит в диапазон рабочих часов пользователя?
            $currentHour = $now->hour;
            if ($currentHour < $user->telegram_reminders_start_hour || $currentHour > $user->telegram_reminders_end_hour) {
                $this->line("Пользователь {$user->name}: текущее время ({$currentHour} ч) вне рабочего диапазона ({$user->telegram_reminders_start_hour}:00 - {$user->telegram_reminders_end_hour}:00).");
                continue;
            }

            // Проверка: прошел ли интервал с момента последней отправки?
            if ($user->telegram_reminders_last_sent_at !== null) {
                $secondsSinceLastSent = $now->timestamp - $user->telegram_reminders_last_sent_at->timestamp;
                $minutesSinceLastSent = (int) ($secondsSinceLastSent / 60);
                if ($minutesSinceLastSent < $user->telegram_reminders_interval) {
                    $this->line("Пользователь {$user->name}: интервал не прошел (прошло {$minutesSinceLastSent} из {$user->telegram_reminders_interval} мин).");
                    continue;
                }
            }

            // Выбираем случайное напоминание
            $reminder = $this->reminders[array_rand($this->reminders)];
            
            // Персонализируем обращение
            $message = "Привет, {$user->name}!\n\n{$reminder}";

            $success = $telegramService->sendMessage($user->telegram_chat_id, $message);

            if ($success) {
                // Обновляем метку времени последней отправки
                $user->update([
                    'telegram_reminders_last_sent_at' => $now
                ]);
                $this->line("Напоминание успешно отправлено пользователю {$user->name} (Chat ID: {$user->telegram_chat_id})");
            } else {
                $this->error("Не удалось отправить напоминание пользователю {$user->name} (Chat ID: {$user->telegram_chat_id})");
            }
        }

        $this->info('Рассылка напоминаний завершена!');
    }
}

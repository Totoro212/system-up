<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TelegramReminderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: пользователь может обновить настройки Telegram в панели целей.
     */
    public function test_user_can_update_telegram_settings(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.telegram.update'), [
                'telegram_chat_id' => '123456789',
                'telegram_reminders_enabled' => '1',
                'telegram_reminders_interval' => '45',
                'telegram_reminders_start_hour' => '10',
                'telegram_reminders_end_hour' => '19',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $user->refresh();
        $this->assertTrue($user->telegram_reminders_enabled);
        $this->assertEquals('123456789', $user->telegram_chat_id);
        $this->assertEquals(45, $user->telegram_reminders_interval);
        $this->assertEquals(10, $user->telegram_reminders_start_hour);
        $this->assertEquals(19, $user->telegram_reminders_end_hour);
    }

    /**
     * Тест: нельзя включить оповещения без указания Chat ID.
     */
    public function test_user_cannot_enable_reminders_without_chat_id(): void
    {
        $user = User::factory()->create([
            'telegram_chat_id' => null
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.telegram.update'), [
                'telegram_chat_id' => '',
                'telegram_reminders_enabled' => '1',
                'telegram_reminders_interval' => '60',
                'telegram_reminders_start_hour' => '9',
                'telegram_reminders_end_hour' => '18',
            ]);

        $response->assertSessionHasErrors(['telegram_chat_id']);
        $user->refresh();
        $this->assertFalse($user->telegram_reminders_enabled);
    }

    /**
     * Тест: отправка тестового оповещения.
     */
    public function test_user_can_trigger_test_notification(): void
    {
        config(['services.telegram.bot_token' => 'test_bot_token']);

        $user = User::factory()->create([
            'telegram_chat_id' => '999888777'
        ]);

        Http::fake([
            'https://api.telegram.org/bottest_bot_token/sendMessage' => Http::response(['ok' => true], 200),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.telegram.test'));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.telegram.org/bottest_bot_token/sendMessage'
                && $request['chat_id'] === '999888777'
                && str_contains($request['text'], 'Тестовое оповещение');
        });
    }

    /**
     * Тест: планировщик соблюдает настроенный интервал.
     */
    public function test_reminders_command_respects_custom_interval(): void
    {
        config(['services.telegram.bot_token' => 'interval_bot_token']);

        // Будний день, 12:00
        Carbon::setTestNow(Carbon::create(2026, 6, 22, 12, 0, 0)); // 22 июня 2026 - понедельник

        $user = User::factory()->create([
            'name' => 'Alice',
            'telegram_chat_id' => '111',
            'telegram_reminders_enabled' => true,
            'telegram_reminders_interval' => 60, // 60 минут
            'telegram_reminders_start_hour' => 9,
            'telegram_reminders_end_hour' => 18,
            'telegram_reminders_last_sent_at' => now()->subMinutes(30), // прошло только 30 минут
        ]);

        Http::fake([
            'https://api.telegram.org/botinterval_bot_token/sendMessage' => Http::response(['ok' => true], 200),
        ]);

        // Запуск
        Artisan::call('reminders:send');

        // HTTP запросы не должны отправляться, так как интервал не пройден
        Http::assertSentCount(0);

        // Перемещаем время вперед на 35 минут (суммарно 65 минут с последней отправки)
        Carbon::setTestNow(now()->addMinutes(35));

        Artisan::call('reminders:send');

        // Теперь запрос должен быть отправлен
        Http::assertSentCount(1);

        $user->refresh();
        $this->assertNotNull($user->telegram_reminders_last_sent_at);
        $this->assertEquals(now()->toDateTimeString(), $user->telegram_reminders_last_sent_at->toDateTimeString());

        Carbon::setTestNow(); // сброс времени
    }

    /**
     * Тест: планировщик соблюдает рабочий диапазон часов.
     */
    public function test_reminders_command_respects_working_hours(): void
    {
        config(['services.telegram.bot_token' => 'hours_bot_token']);

        // Будний день, 21:00 (вне диапазона 9:00 - 18:00)
        Carbon::setTestNow(Carbon::create(2026, 6, 22, 21, 0, 0));

        User::factory()->create([
            'name' => 'Bob',
            'telegram_chat_id' => '222',
            'telegram_reminders_enabled' => true,
            'telegram_reminders_interval' => 30,
            'telegram_reminders_start_hour' => 9,
            'telegram_reminders_end_hour' => 18,
            'telegram_reminders_last_sent_at' => null,
        ]);

        Http::fake([
            'https://api.telegram.org/bothours_bot_token/sendMessage' => Http::response(['ok' => true], 200),
        ]);

        Artisan::call('reminders:send');

        // Запросы не должны отправляться ночью
        Http::assertSentCount(0);

        Carbon::setTestNow(); // сброс времени
    }
}

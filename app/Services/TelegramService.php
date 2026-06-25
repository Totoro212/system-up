<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected ?string $botToken;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
    }

    /**
     * Отправить сообщение в Telegram.
     *
     * @param string $chatId
     * @param string $text
     * @return bool
     */
    public function sendMessage(string $chatId, string $text): bool
    {
        if (empty($this->botToken)) {
            Log::warning('Telegram Bot Token is not configured.');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Telegram API error: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Telegram HTTP request failed: ' . $e->getMessage());
            return false;
        }
    }
}

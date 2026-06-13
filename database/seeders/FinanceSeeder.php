<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        if (!$user) return;

        // Create Accounts
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Ipak Yuli Visa', 'type' => 'card', 'currency' => 'UZS', 'balance' => 16000, 'cashback_note' => '0.05% кэшбек']);
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Uzum Visa', 'type' => 'card', 'currency' => 'UZS', 'balance' => 434000, 'cashback_note' => 'Разные кэшбеки']);
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Наличные (Сум)', 'type' => 'cash', 'currency' => 'UZS', 'balance' => 500000]); // Moved 1.5m to deposit
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Вклад Uzum', 'type' => 'deposit', 'currency' => 'UZS', 'balance' => 4000000]); // 2.5m + 1.5m
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Личные Наличные', 'type' => 'cash', 'currency' => 'USD', 'balance' => 800]);
        \App\Models\Account::create(['user_id' => $user->id, 'name' => 'Семейный Конверт', 'type' => 'cash', 'currency' => 'USD', 'balance' => 370, 'is_joint' => true]);

        // Create Funds (Virtual Buckets)
        \App\Models\Fund::create(['user_id' => $user->id, 'name' => 'Базовые нужды', 'target_percentage' => 50, 'balance' => 0, 'currency' => 'UZS', 'icon' => '🛒', 'color' => 'emerald']);
        \App\Models\Fund::create(['user_id' => $user->id, 'name' => 'Желания и Лайфстайл', 'target_percentage' => 40, 'balance' => 0, 'currency' => 'UZS', 'icon' => '✨', 'color' => 'yellow']);
        \App\Models\Fund::create(['user_id' => $user->id, 'name' => 'Сбережения', 'target_percentage' => 10, 'balance' => 0, 'currency' => 'UZS', 'icon' => '🏦', 'color' => 'indigo']);
        \App\Models\Fund::create(['user_id' => $user->id, 'name' => 'Семейный капитал', 'target_percentage' => null, 'balance' => 370, 'currency' => 'USD', 'icon' => '👨‍👩‍👦', 'color' => 'purple']);
    }
}

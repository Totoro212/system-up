<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('user:create {name} {email} {password}', function ($name, $email, $password) {
    if (\App\Models\User::where('email', $email)->exists()) {
        $this->error("Пользователь с email {$email} уже существует!");
        return;
    }

    $user = \App\Models\User::create([
        'name' => $name,
        'email' => $email,
        'password' => \Illuminate\Support\Facades\Hash::make($password),
    ]);

    $this->info("Пользователь {$user->name} ({$user->email}) успешно создан!");
})->purpose('Создать нового пользователя вручную');

// Расписание отправки напоминаний в телеграм (проверяем каждые 5 минут, пользователи сами настраивают интервалы)
Schedule::command('reminders:send')->everyFiveMinutes();

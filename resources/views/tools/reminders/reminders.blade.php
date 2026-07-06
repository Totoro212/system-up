<!-- ================= ЭКРАН: НАПОМИНАНИЯ ================= -->
<template x-if="currentTab === 'reminders'">
    <div class="space-y-6 max-w-2xl mx-auto pb-20">

        <!-- Шапка -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-900/50">
            <button @click="currentTab = 'hub'"
                class="text-[10px] font-extrabold text-emerald-400 hover:text-emerald-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                <span>←</span>
                <span>В Инструменты</span>
            </button>
            <x-h1 class="text-2xl text-slate-100">🔔 Напоминания</x-h1>
        </div>

        <x-card class="p-6 bg-slate-900/60 border border-slate-800 shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <x-h3 class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500 mb-4">Настройки Telegram-оповещений</x-h3>

                <form method="POST" action="{{ route('life-goals.telegram.update') }}" class="space-y-6">
                    @csrf

                    <!-- Чекбокс включения -->
                    <div class="flex items-center justify-between p-4 bg-slate-950/50 rounded-xl border border-slate-850">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-200">Включить напоминания</span>
                            <span class="text-xs text-slate-500 mt-0.5">Получать регулярные напоминания в Telegram</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="telegram_reminders_enabled" value="1" class="sr-only peer" {{ auth()->user()->telegram_reminders_enabled ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 peer-checked:after:bg-slate-950 peer-checked:after:border-emerald-500"></div>
                        </label>
                    </div>

                    <!-- Chat ID -->
                    <div class="space-y-2">
                        <label for="telegram_chat_id" class="text-xs font-bold text-slate-400 uppercase tracking-wide">Telegram Chat ID</label>
                        <input type="text" id="telegram_chat_id" name="telegram_chat_id" value="{{ old('telegram_chat_id', auth()->user()->telegram_chat_id) }}" placeholder="Например: 123456789"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0">
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Ваш уникальный ID. Его можно узнать у ботов <a href="https://t.me/userinfobot" target="_blank" class="text-indigo-400 hover:underline">@userinfobot</a> или <a href="https://t.me/cidbot" target="_blank" class="text-indigo-400 hover:underline">@cidbot</a>.
                        </p>
                    </div>

                    <!-- Интервал отправки -->
                    <div class="space-y-2">
                        <label for="telegram_reminders_interval" class="text-xs font-bold text-slate-400 uppercase tracking-wide">Интервал напоминаний</label>
                        <select id="telegram_reminders_interval" name="telegram_reminders_interval"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 focus:border-emerald-500/50 focus:ring-0">
                            <option value="30" {{ auth()->user()->telegram_reminders_interval == 30 ? 'selected' : '' }}>Каждые 30 минут</option>
                            <option value="45" {{ auth()->user()->telegram_reminders_interval == 45 ? 'selected' : '' }}>Каждые 45 минут</option>
                            <option value="60" {{ auth()->user()->telegram_reminders_interval == 60 ? 'selected' : '' }}>Каждый час</option>
                            <option value="90" {{ auth()->user()->telegram_reminders_interval == 90 ? 'selected' : '' }}>Каждые 1.5 часа</option>
                            <option value="120" {{ auth()->user()->telegram_reminders_interval == 120 ? 'selected' : '' }}>Каждые 2 часа</option>
                        </select>
                    </div>

                    <!-- Диапазон рабочих часов -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="telegram_reminders_start_hour" class="text-xs font-bold text-slate-400 uppercase tracking-wide">Начало (час)</label>
                            <select id="telegram_reminders_start_hour" name="telegram_reminders_start_hour"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 focus:border-emerald-500/50 focus:ring-0">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" {{ auth()->user()->telegram_reminders_start_hour == $i ? 'selected' : '' }}>{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="telegram_reminders_end_hour" class="text-xs font-bold text-slate-400 uppercase tracking-wide">Конец (час)</label>
                            <select id="telegram_reminders_end_hour" name="telegram_reminders_end_hour"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 focus:border-emerald-500/50 focus:ring-0">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" {{ auth()->user()->telegram_reminders_end_hour == $i ? 'selected' : '' }}>{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Кнопки управления -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit"
                            class="flex-grow py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 font-bold transition-all text-sm shadow-lg shadow-emerald-900/20 text-center cursor-pointer">
                            Сохранить настройки
                        </button>
                </form>

                <!-- Кнопка проверки в отдельной форме -->
                <form method="POST" action="{{ route('life-goals.telegram.test') }}" class="flex-grow">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-slate-950 border border-slate-850 text-slate-300 hover:text-slate-100 hover:bg-slate-900 font-bold transition-all text-sm text-center cursor-pointer">
                        🧪 Проверить связь
                    </button>
                </form>
            </div>
        </x-card>
    </div>
</template>

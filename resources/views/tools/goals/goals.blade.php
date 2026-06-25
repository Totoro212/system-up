<!-- ================= ЭКРАН: ЦЕЛИ ================= -->
<template x-if="currentTab === 'goals'">
    <div class="space-y-6 max-w-2xl mx-auto pb-20">

        <!-- Шапка -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-900/50">
            <button @click="currentTab = 'hub'"
                class="text-[10px] font-extrabold text-emerald-400 hover:text-emerald-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                <span>←</span>
                <span>В Инструменты</span>
            </button>
            <x-h1 class="text-2xl text-slate-100">🎯 Цели</x-h1>
        </div>

        <!-- Подвкладки (Sub-tabs) -->
        <div x-data="{ activeGoalTab: localStorage.getItem('activeGoalTab') || 'life' }" x-init="$watch('activeGoalTab', val => localStorage.setItem('activeGoalTab', val))">
            <div class="flex gap-2 p-1 bg-slate-950 rounded-xl border border-slate-900 mb-6">
                <button @click="activeGoalTab = 'life'"
                    :class="activeGoalTab === 'life' ? 'bg-slate-900 text-emerald-400 border-slate-800' : 'text-slate-400 hover:text-slate-200 border-transparent'"
                    class="flex-1 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all border cursor-pointer text-center">
                    🎯 Жизненные цели
                </button>
                <button @click="activeGoalTab = 'finance'"
                    :class="activeGoalTab === 'finance' ? 'bg-slate-900 text-emerald-400 border-slate-800' : 'text-slate-400 hover:text-slate-200 border-transparent'"
                    class="flex-1 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all border cursor-pointer text-center">
                    💰 Накопления
                </button>
            </div>

            <!-- Вкладка: ЖИЗНЕННЫЕ ЦЕЛИ -->
            <div x-show="activeGoalTab === 'life'" class="space-y-6" style="display: none;">
                <!-- Добавить Жизненную Цель (Скрытая форма) -->
                <div x-data="{ showAddLifeGoal: false }" class="mb-4">
                    <!-- Кнопка вместо формы -->
                    <button x-show="!showAddLifeGoal" @click="showAddLifeGoal = true"
                        class="w-full py-4 rounded-2xl border border-dashed border-slate-700/50 text-slate-500 hover:text-emerald-400 hover:border-emerald-500/30 hover:bg-emerald-500/5 transition-all font-bold text-sm flex items-center justify-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Добавить жизненную цель
                    </button>

                    <!-- Форма добавления -->
                    <x-card x-show="showAddLifeGoal" style="display: none;"
                        class="p-6 bg-slate-900/60 border border-slate-800 shadow-xl relative overflow-hidden animate-fade-in">
                        <div
                            class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <div class="flex justify-between items-center mb-4 relative z-10">
                            <x-h3 class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Новая жизненная цель</x-h3>
                            <button @click="showAddLifeGoal = false"
                                class="text-slate-500 hover:text-rose-400 transition-colors cursor-pointer w-6 h-6 flex items-center justify-center rounded-md hover:bg-slate-800">
                                ✕
                            </button>
                        </div>

                        <form method="POST" action="{{ route('life-goals.store') }}"
                            class="space-y-3 relative z-10">
                            @csrf
                            <input type="text" name="title" placeholder="Что нужно сделать? (напр. Выучить Laravel)" required
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0">
                            <textarea name="description" placeholder="Описание / Заметки / Ссылки (необязательно)" rows="3"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0 resize-none"></textarea>
                            
                            <div class="flex justify-end pt-1">
                                <button type="submit"
                                    class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 font-bold transition-all text-sm shrink-0 shadow-lg shadow-emerald-900/20">
                                    Создать
                                </button>
                            </div>
                        </form>
                    </x-card>
                </div>

                <!-- Список Жизненных Целей -->
                <div class="space-y-4 pt-2">
                    @if (isset($lifeGoals) && $lifeGoals->count() > 0)
                        @foreach ($lifeGoals as $lifeGoal)
                            <div
                                class="bg-slate-900/60 border border-slate-800 rounded-2xl p-5 relative overflow-hidden shadow-lg group hover:border-slate-700 transition-colors flex items-start gap-4">
                                
                                <!-- Кастомный чекбокс (форма переключения статуса) -->
                                <form method="POST" action="{{ route('life-goals.toggle', $lifeGoal->id) }}" class="mt-1 shrink-0">
                                    @csrf
                                    <button type="submit" 
                                        class="w-6 h-6 rounded-full border-2 transition-all flex items-center justify-center cursor-pointer {{ $lifeGoal->is_completed ? 'bg-emerald-500 border-emerald-500 text-slate-950 hover:bg-emerald-600 hover:border-emerald-600' : 'border-slate-700 hover:border-emerald-500/50' }}">
                                        @if ($lifeGoal->is_completed)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-2">
                                        <div class="min-w-0">
                                            <h3 class="text-base sm:text-lg font-black truncate-normal {{ $lifeGoal->is_completed ? 'text-slate-500 line-through' : 'text-slate-100' }}">
                                                {{ $lifeGoal->title }}
                                            </h3>
                                            
                                            @if ($lifeGoal->description)
                                                <p class="text-xs sm:text-sm text-slate-400 mt-1.5 whitespace-pre-line leading-relaxed {{ $lifeGoal->is_completed ? 'text-slate-600' : '' }}">
                                                    {{ $lifeGoal->description }}
                                                </p>
                                            @endif

                                            @if ($lifeGoal->is_completed && $lifeGoal->completed_at)
                                                <p class="text-[10px] font-extrabold text-emerald-500/70 uppercase tracking-wider mt-2.5">
                                                    🎉 Выполнено {{ $lifeGoal->completed_at->format('d.m.Y H:i') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0 self-end sm:self-start mt-2 sm:mt-0">
                                            <form method="POST" action="{{ route('life-goals.destroy', $lifeGoal->id) }}" onsubmit="return confirm('Удалить эту жизненную цель?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg bg-slate-950/60 border border-slate-850/50 hover:bg-rose-500/10 hover:border-rose-500/30 text-[10px] font-bold text-slate-400 hover:text-rose-400 cursor-pointer transition-all flex items-center gap-1 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity"
                                                    title="Удалить цель">
                                                    <span>🗑️</span> Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Подсветка при завершении -->
                                @if ($lifeGoal->is_completed)
                                    <div
                                        class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-16 bg-slate-900/30 border border-slate-800/50 rounded-2xl border-dashed">
                            <span class="text-4xl block mb-3">🎯</span>
                            <p class="text-slate-400 font-medium">У вас пока нет жизненных целей.</p>
                            <p class="text-xs text-slate-500 mt-1">Добавьте первую цель выше, чтобы зафиксировать её.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Вкладка: ФИНАНСОВЫЕ ЦЕЛИ (НАКОПЛЕНИЯ) -->
            <div x-show="activeGoalTab === 'finance'" class="space-y-6" style="display: none;">
                <!-- Добавить Цель (Скрытая форма) -->
                <div x-data="{ showAddGoal: false }" class="mb-4">
                    <!-- Кнопка вместо формы -->
                    <button x-show="!showAddGoal" @click="showAddGoal = true"
                        class="w-full py-4 rounded-2xl border border-dashed border-slate-700/50 text-slate-500 hover:text-emerald-400 hover:border-emerald-500/30 hover:bg-emerald-500/5 transition-all font-bold text-sm flex items-center justify-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Добавить новую финансовую цель
                    </button>

                    <!-- Сама форма -->
                    <x-card x-show="showAddGoal" style="display: none;"
                        class="p-6 bg-slate-900/60 border border-slate-800 shadow-xl relative overflow-hidden animate-fade-in">
                        <div
                            class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <div class="flex justify-between items-center mb-4 relative z-10">
                            <x-h3 class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Новая цель накопления</x-h3>
                            <button @click="showAddGoal = false"
                                class="text-slate-500 hover:text-rose-400 transition-colors cursor-pointer w-6 h-6 flex items-center justify-center rounded-md hover:bg-slate-800">
                                ✕
                            </button>
                        </div>

                        <form method="POST" action="{{ route('finance.goals.store') }}"
                            class="flex flex-col sm:flex-row gap-3 relative z-10">
                            @csrf
                            <input type="text" name="name" placeholder="Название (напр. Машина)" required
                                class="flex-1 bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0">
                            <input type="number" name="target_amount" placeholder="Сумма цели (UZS)" required
                                class="flex-1 bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0 sm:text-right"
                                style="-moz-appearance: textfield;">
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 font-bold transition-all text-sm shrink-0 shadow-lg shadow-emerald-900/20">
                                Создать
                            </button>
                        </form>
                    </x-card>
                </div>

                <!-- Список Целей -->
                <div class="space-y-4 pt-2">
                    @if (isset($goals) && $goals->count() > 0)
                        @foreach ($goals as $goal)
                            @php
                                $displayAmount = min($goal->current_amount, $goal->target_amount);
                                $percent = $goal->target_amount > 0 ? ($displayAmount / $goal->target_amount) * 100 : 0;
                            @endphp
                            <div
                                class="bg-slate-900/60 border border-slate-800 rounded-2xl p-5 relative overflow-hidden shadow-lg group hover:border-slate-700 transition-colors">

                                <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-2 relative z-10 gap-2 sm:gap-0">
                                    <div>
                                        <h3 class="text-lg sm:text-xl font-black text-slate-100">{{ $goal->name }}</h3>
                                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                            <span
                                                class="text-emerald-400 font-bold">{{ number_format($displayAmount, 0, '', ' ') }}</span>
                                            из {{ number_format($goal->target_amount, 0, '', ' ') }} UZS
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-start sm:items-end gap-2 mt-1 sm:mt-0">
                                        <span
                                            class="text-2xl sm:text-3xl font-black drop-shadow-md {{ $percent >= 100 ? 'text-emerald-400 drop-shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'text-slate-300' }}">
                                            {{ number_format($percent, 1) }}%
                                        </span>
                                        
                                        <div class="flex items-center gap-1.5 mt-1">
                                            @if($goal->current_amount > 0)
                                                <form method="POST" action="{{ route('finance.goals.reset', $goal->id) }}" onsubmit="return confirm('Сбросить накопления по этой цели?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg bg-slate-950/60 border border-slate-850/50 hover:bg-amber-500/10 hover:border-amber-500/30 text-[10px] font-bold text-slate-400 hover:text-amber-400 cursor-pointer transition-all flex items-center gap-1"
                                                        title="Сбросить накопления">
                                                        <span>🔄</span> Сбросить
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('finance.goals.destroy', $goal->id) }}" onsubmit="return confirm('Удалить эту цель?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg bg-slate-950/60 border border-slate-850/50 hover:bg-rose-500/10 hover:border-rose-500/30 text-[10px] font-bold text-slate-400 hover:text-rose-400 cursor-pointer transition-all flex items-center gap-1"
                                                    title="Удалить цель">
                                                    <span>🗑️</span> Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Прогресс-бар -->
                                <div
                                    class="h-4 bg-slate-950 rounded-full overflow-hidden border border-slate-800 mt-4 mb-5 relative z-10 shadow-inner">
                                    <div class="h-full {{ $percent >= 100 ? 'bg-emerald-400' : 'bg-gradient-to-r from-emerald-500 to-teal-400' }} transition-all duration-1000 relative"
                                        style="width: {{ $percent }}%">
                                        <div
                                            class="absolute inset-0 bg-white/20 w-full animate-[pulse_2s_ease-in-out_infinite]">
                                        </div>
                                    </div>
                                </div>

                                <!-- Пополнение -->
                                @if ($percent < 100)
                                    <form method="POST" action="{{ route('finance.goals.add', $goal->id) }}"
                                        x-data="{ loading: false }"
                                        @submit="if (loading) { $event.preventDefault(); return; } loading = true"
                                        class="flex flex-col sm:flex-row gap-2 relative z-10 opacity-100 sm:opacity-60 group-hover:opacity-100 transition-opacity duration-300">
                                        @csrf
                                        <input type="number" name="amount" placeholder="Сумма пополнения" required
                                            :readonly="loading"
                                            class="flex-1 bg-slate-950 border border-slate-800 rounded-lg px-4 py-2 text-sm text-slate-200 placeholder-slate-600 focus:border-emerald-500/50 focus:ring-0 font-medium transition-all"
                                            :class="loading ? 'opacity-50 cursor-not-allowed' : ''"
                                            style="-moz-appearance: textfield;">
                                        <button type="submit"
                                            :disabled="loading"
                                            class="w-full sm:w-auto px-5 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 font-bold text-sm transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5">
                                            <template x-if="loading">
                                                <svg class="animate-spin h-3.5 w-3.5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </template>
                                            <span x-text="loading ? 'Пополнение...' : '+ Пополнить'"></span>
                                        </button>
                                    </form>
                                @else
                                    <div
                                        class="text-center py-2.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg relative z-10">
                                        <span class="text-emerald-400 font-bold text-sm tracking-wide">🎉 Цель
                                            достигнута!</span>
                                    </div>
                                @endif

                                <!-- Подсветка при достижении цели -->
                                @if ($percent >= 100)
                                    <div
                                        class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-16 bg-slate-900/30 border border-slate-800/50 rounded-2xl border-dashed">
                            <span class="text-4xl block mb-3">💰</span>
                            <p class="text-slate-400 font-medium">У вас пока нет ни одной финансовой цели.</p>
                            <p class="text-xs text-slate-500 mt-1">Добавьте первую цель выше, чтобы начать отслеживать накопления.</p>
                        </div>
                    @endif
            </div>
        </div>

    </div>
</template>

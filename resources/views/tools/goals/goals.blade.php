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
            <x-h1 class="text-2xl text-slate-100">🎯 Жизненные цели</x-h1>
        </div>

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
</template>

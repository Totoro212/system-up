@extends('layouts.app')

@section('content')
    @php
        $totalQuests = count($quests);
        $completedQuests = $quests->where('log_exists', true)->count();
    @endphp
    <!-- Контейнер расширен до max-w-2xl для идеальной симметрии и пропорций с тренировками -->
    <!-- Контейнер с реактивным стейтом для мгновенного обновления прогресса в реальном времени -->
    <div class='max-w-2xl mx-auto p-4 space-y-6 pb-20' x-data="{
        completedCount: {{ $completedQuests }},
        totalCount: {{ $totalQuests }},
        get progressPercent() {
            return this.totalCount > 0 ? Math.round((this.completedCount / this.totalCount) * 100) : 0;
        }
    }">

        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <div>
                <h1 class="text-2xl font-black tracking-wider text-slate-100 uppercase">Мои квесты</h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">
                    <span x-text="completedCount"></span> / <span x-text="totalCount"></span> Выполнено
                </p>
            </div>
            
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-quest')" 
                    class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-lg shadow-indigo-950/40 hover:-translate-y-0.5">
                <span>+</span>
                <span>Новый квест</span>
            </button>
        </div>

        <!-- Уведомления об успехе (Success Alert) -->
        @if (session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Визуальный прогресс-бар выполнения -->
        <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-4 shadow-lg">
            <div class="flex justify-between items-center mb-2.5">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">📊 Прогресс дня</span>
                <span class="text-xs font-black text-slate-200 font-mono" x-text="completedCount + ' / ' + totalCount"></span>
            </div>
            <div class="w-full h-3 bg-slate-950 rounded-full overflow-hidden border border-slate-900/80">
                <div class="h-full rounded-full transition-all duration-500 ease-out"
                     :class="progressPercent === 100 ? 'bg-gradient-to-r from-emerald-500 to-emerald-400' : 'bg-gradient-to-r from-indigo-600 to-violet-500'"
                     :style="'width: ' + progressPercent + '%'"></div>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-[10px] font-bold text-slate-500">0%</span>
                <span class="text-xs font-black transition-colors duration-300" :class="progressPercent === 100 ? 'text-emerald-400' : 'text-indigo-400'" x-text="progressPercent + '%'"></span>
                <span class="text-[10px] font-bold text-slate-500">100%</span>
            </div>
        </div>

        <!-- Список квестов -->
        <div class="space-y-4">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">🎯 Активные квесты на сегодня</h2>
            
            @forelse ($quests as $quest)
                <div x-data="{ completed: {{ $quest->log_exists ? 'true' : 'false' }}, loading: false }" 
                     class="relative group transition-all duration-300">
                    
                    <button type="button" 
                            @click="
                                if (loading) return;
                                loading = true;
                                const oldState = completed;
                                completed = !completed;
                                completed ? completedCount++ : completedCount--;
                                fetch('{{ route('quest_complete', $quest->id) }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    loading = false;
                                    if (data.success) {
                                        // Если статус разошелся с ожидаемым (например, два быстрых клика)
                                        if (completed !== data.completed) {
                                            completed = data.completed;
                                            completed ? completedCount++ : completedCount--;
                                        }
                                    } else {
                                        // Откат в случае ошибки
                                        completed = oldState;
                                        completed ? completedCount++ : completedCount--;
                                    }
                                })
                                .catch(err => {
                                    loading = false;
                                    completed = oldState;
                                    completed ? completedCount++ : completedCount--;
                                });
                            "
                            class="w-full text-left flex items-center gap-4 border-l-4 rounded-2xl p-5 shadow-lg transition-all duration-300 cursor-pointer focus:outline-none group/card"
                            :class="completed ? 'bg-slate-900/35 border-slate-950/80 border-l-emerald-500' : 'bg-slate-900/70 border-slate-900/60 border-l-indigo-500 hover:border-indigo-500/30 hover:bg-slate-900/40 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-950/20'">
                        
                        <!-- Интерактивный кастомный чекбокс -->
                        <div class="flex-shrink-0 w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-all duration-300"
                             :class="completed ? 'bg-emerald-500/10 border-emerald-500' : 'border-slate-700 group-hover/card:border-indigo-400 group-hover/card:bg-indigo-500/10'">
                            <!-- Птичка (для выполненного) -->
                            <svg x-show="completed" class="w-3.5 h-3.5 text-emerald-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <!-- Точка предпросмотра (для активного при наведении) -->
                            <div x-show="!completed" class="w-2.5 h-2.5 bg-indigo-500 rounded-sm scale-0 group-hover/card:scale-100 transition-transform duration-200"></div>
                        </div>

                        <div class="flex-grow pr-8">
                            <h3 class="text-sm font-black uppercase tracking-wide transition-all duration-300"
                                :class="completed ? 'text-slate-500 line-through font-extrabold' : 'text-slate-100'">
                                {{ $quest->title }}
                            </h3>
                            
                            <!-- Описание для активного квеста -->
                            <p x-show="!completed" class="text-xs text-slate-350 leading-relaxed font-sans mt-1">
                                {{ $quest->description }}
                            </p>
                            <!-- Подсказка для выполненного квеста -->
                            <p x-show="completed" class="text-xs text-slate-600 font-sans mt-0.5 leading-relaxed" style="display: none;">
                                Выполнено. Нажмите в любое место карточки, чтобы сбросить.
                            </p>
                        </div>
                    </button>

                    <!-- Кнопка удаления (для личных и системных квестов) -->
                    @if ($quest->user_id === null || $quest->user_id === auth()->id())
                        <form method="POST" action="{{ route('quests.destroy', $quest->id) }}" class="absolute top-1/2 -translate-y-1/2 right-4 z-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-xl bg-slate-950/80 hover:bg-red-950/30 text-slate-500 hover:text-red-400 border border-slate-900/60 hover:border-red-900/40 flex items-center justify-center transition-all cursor-pointer"
                                title="Удалить квест">
                                <span class="text-xs">✕</span>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 px-6 bg-slate-900/20 rounded-2xl border border-slate-900/50 space-y-4">
                    <span class="text-3xl block">📭</span>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Список квестов пуст</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Создайте ваш первый квест с помощью кнопки сверху или мгновенно загрузите ежедневные квесты по умолчанию!
                    </p>
                    <div class="pt-2">
                        <form method="POST" action="{{ route('quests.seed_default') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-lg shadow-indigo-950/40 hover:-translate-y-0.5">
                                🚀 Загрузить квесты по умолчанию
                            </button>
                        </form>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Модальное окно создания квеста -->
        <x-modal name="create-quest" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6">
                <h2 class="text-base font-bold text-slate-100 uppercase tracking-wider mb-4 pb-2 border-b border-slate-800/80">Создать личный квест</h2>
                
                <form method="POST" action="{{ route('quests.store') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Название</label>
                        <input type="text" name="title" id="title" required placeholder="Например: Выпить 2 литра воды"
                               class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors">
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>
                    
                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Описание</label>
                        <input type="text" name="description" id="description" required placeholder="Детали, регулярность или цель..."
                               class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors">
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs tracking-wider uppercase transition-all cursor-pointer">
                            Добавить в список
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>



    </div>
@endsection

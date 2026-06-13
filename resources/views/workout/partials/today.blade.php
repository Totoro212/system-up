        <!-- ================= БЛОК: СЕГОДНЯ В РАСПИСАНИИ ================= -->
        <div>
            <x-h2 class="mb-3">Следующая в очереди</x-h2>

            @if ($todayWorkout)
                <div
                    class="bg-slate-900 border-2 border-indigo-500/30 rounded-2xl p-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>

                    <!-- Шапка -->
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <span class="text-xs font-extrabold text-indigo-400 uppercase tracking-widest block">⭐
                                СЛЕДУЮЩАЯ ТРЕНИРОВКА</span>
                            <x-h3 class="text-xl mt-1">
                                {{ $todayWorkout->title }}</x-h3>
                        </div>

                        <!-- Статус тонуса -->
                        <span
                            class="px-3 py-1 rounded-lg border text-xs font-black uppercase tracking-wider {{ $todayWorkout->status_color }}">
                            {{ $todayWorkout->status_label }}
                        </span>
                    </div>

                    <!-- Форма выполнения тренировки с записью рабочих весов -->
                    <form method="POST" action="{{ route('workouts.complete', $todayWorkout->id) }}">
                        @csrf

                        <!-- Список упражнений на сегодня -->
                        <div class="mt-6 space-y-4">
                            @foreach ($todayWorkout->exercises as $exercise)
                                <div class="bg-slate-950/50 border border-slate-900/60 rounded-xl p-4">
                                    <div class="flex justify-between items-center flex-wrap gap-2">
                                        <x-h3>
                                            {{ $exercise->title }}</x-h3>
                                        <span
                                            class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/5 px-2.5 py-1 rounded border border-emerald-500/10">
                                            {{ $exercise->sets }} × {{ $exercise->reps }}
                                        </span>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mt-2.5">
                                        @if ($exercise->target_muscles)
                                            <span
                                                class="text-xs font-bold text-slate-300 bg-slate-800/60 px-2.5 py-0.5 rounded">
                                                🎯 {{ $exercise->target_muscles }}
                                            </span>
                                        @endif
                                        @if ($exercise->weight)
                                            <span
                                                class="text-xs font-bold text-amber-400 bg-amber-500/5 px-2.5 py-0.5 rounded border border-amber-500/10">
                                                💪 {{ $exercise->weight }}
                                            </span>
                                        @endif

                                        <!-- Бейдж прогрессии -->
                                        @if ($exercise->progression_status !== 'new')
                                            <span
                                                class="text-xs font-bold px-2.5 py-0.5 rounded border {{ $exercise->progression_color }}">
                                                📈 {{ $exercise->progression_label }}
                                            </span>
                                        @endif

                                        <!-- Рекомендация при стагнации или регрессе -->
                                        @if ($exercise->suggested_weight)
                                            <span
                                                class="text-xs font-bold text-amber-300 bg-amber-500/5 px-2.5 py-0.5 rounded border border-amber-400/20 animate-pulse">
                                                ⚡ Рекомендуем: {{ $exercise->suggested_weight }} кг
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Инпут для ввода рабочего веса -->
                                    <div class="mt-3 flex items-center gap-2">
                                        <label
                                            class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest whitespace-nowrap">Вес
                                            (кг):</label>
                                        <input type="number" name="weights[{{ $exercise->id }}]" step="0.5"
                                            min="0" max="500"
                                            placeholder="{{ $exercise->suggested_weight ?? ($exercise->last_weight ?? 'кг') }}"
                                            value="{{ $exercise->last_weight }}"
                                            class="w-full bg-slate-950 border border-slate-900 rounded-lg px-3 py-2 text-xs text-slate-200 font-mono placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    @if ($exercise->description)
                                        <x-p
                                            class="text-slate-300 mt-3 bg-slate-950 p-3 rounded-lg border border-slate-850/80 whitespace-pre-line">
                                            {{ $exercise->description }}
                                        </x-p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Кнопка «Выполнить тренировку» -->
                        <x-primary-button class="w-full mt-5 py-3 text-xs tracking-widest">
                            <span>✅</span>
                            <span>Выполнить и записать веса</span>
                        </x-primary-button>
                    </form>
                </div>
            @else
                <!-- Все тренировки выполнены -->
                <div
                    class="bg-slate-900/40 border border-slate-900 rounded-2xl p-8 text-center shadow-lg relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
                    <span class="text-3xl block">✨</span>
                    <x-h3 class="text-slate-200 tracking-widest mt-2.5">Все тренировки выполнены!</x-h3>
                    <x-p class="text-slate-400 mt-1.5 max-w-[280px] mx-auto">
                        Отличная работа! Восстановись, выспись — завтра продолжим очередь с новой тренировкой.
                    </x-p>
                </div>
            @endif
        </div>

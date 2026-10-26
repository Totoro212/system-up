        <!-- ================= БЛОК: СЕГОДНЯ В РАСПИСАНИИ ================= -->
        <div>
            <x-h2 class="mb-3">Следующая в очереди</x-h2>

            @if ($todayWorkout)
                <div
                    class="bg-white border-2 border-indigo-500/20 rounded-2xl p-6 shadow-[0_4px_24px_rgba(15,23,42,0.04)] relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>

                    <!-- Шапка -->
                    <div>
                        <span class="text-xs font-extrabold text-indigo-700 uppercase tracking-widest block">⭐
                            СЛЕДУЮЩАЯ ТРЕНИРОВКА</span>
                        <x-h3 class="text-xl mt-1 font-black text-slate-900">
                            {{ $todayWorkout->title }}</x-h3>
                    </div>

                    <!-- Форма выполнения тренировки с записью рабочих весов -->
                    <form method="POST" action="{{ route('workouts.complete', $todayWorkout->id) }}">
                        @csrf

                        <!-- Список упражнений на сегодня -->
                        <div class="mt-6 space-y-4">
                            @foreach ($todayWorkout->exercises as $exercise)
                                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4">
                                    <div>
                                        <x-h3 class="text-slate-900 font-bold">
                                            {{ $exercise->title }}</x-h3>
                                        <div class="text-xs font-mono font-bold text-emerald-600 mt-1">
                                            {{ $exercise->sets }} × {{ $exercise->reps }}
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mt-2.5">
                                        @if ($exercise->target_muscles)
                                            <span
                                                class="text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded border border-slate-200/60">
                                                🎯 {{ $exercise->target_muscles }}
                                            </span>
                                        @endif
                                        @if ($exercise->weight)
                                            <span
                                                class="text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded border border-amber-200/60">
                                                💪 {{ $exercise->weight }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($exercise->description)
                                        <x-p
                                            class="text-slate-600 mt-3 bg-white p-3 rounded-lg border border-slate-200/80 whitespace-pre-line">
                                            {{ $exercise->description }}
                                        </x-p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Кнопка «Выполнить тренировку» -->
                        <x-primary-button class="w-full mt-5 py-3 text-xs tracking-widest">
                            <span>✅</span>
                            <span>Выполнить тренировку</span>
                        </x-primary-button>
                    </form>
                </div>
            @else
                <!-- Все тренировки выполнены -->
                <div
                    class="bg-white/80 border border-slate-200/90 rounded-2xl p-8 text-center shadow-sm relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
                    <span class="text-3xl block">✨</span>
                    <x-h3 class="text-slate-800 tracking-widest mt-2.5">Все тренировки выполнены!</x-h3>
                    <x-p class="text-slate-400 mt-1.5 max-w-[280px] mx-auto">
                        Отличная работа! Восстановись, выспись — завтра продолжим очередь с новой тренировкой.
                    </x-p>
                </div>
            @endif
        </div>

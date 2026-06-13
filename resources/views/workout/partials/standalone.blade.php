        <!-- ================= БЛОК: ОТДЕЛЬНЫЕ ТРЕНИРОВКИ (ВНЕ ПРОГРАММЫ) ================= -->
        @if ($standaloneWorkouts->count() > 0)
        <div x-data="{ activeStandalone: null }" class="space-y-3.5">
            <x-h2>🎯 Вне программы</x-h2>

            @foreach ($standaloneWorkouts as $workout)
                <x-card class="bg-slate-900/40 border-slate-800/50 duration-200">
                    <div class="flex justify-between items-center gap-4">
                        <div class="cursor-pointer flex-1"
                            x-on:click="activeStandalone = activeStandalone === {{ $workout->id }} ? null : {{ $workout->id }}">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="text-xs font-bold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded">
                                    Свободная
                                </span>
                                <span class="px-2.5 py-0.5 rounded text-xs font-black uppercase tracking-wider border {{ $workout->status_color }}">
                                    {{ $workout->status_label }}
                                </span>
                            </div>
                            <x-h3 class="text-base mt-2.5 flex items-center gap-2">
                                <span>{{ $workout->title }}</span>
                                <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                    :class="activeStandalone === {{ $workout->id }} ? 'rotate-180' : ''">&#9660;</span>
                            </x-h3>
                            <x-p class="text-slate-400 mt-1.5">
                                @if ($workout->last_performed_at)
                                    Выполнялась: {{ $workout->last_performed_at->diffForHumans() }}
                                @else
                                    Еще ни разу не выполнялась
                                @endif
                            </x-p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('workouts.complete', $workout->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600/80 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider transition-all cursor-pointer">
                                    ✅ Выполнить
                                </button>
                            </form>
                            <form method="POST" action="{{ route('workouts.destroy', $workout->id) }}"
                                onsubmit="return confirm('Удалить эту тренировку?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-xl bg-slate-950 border border-slate-900 text-slate-400 hover:text-red-400 hover:border-red-900/30 flex items-center justify-center transition-colors cursor-pointer">
                                    <span class="text-xs">✕</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @include('workout._exercise-list', ['workout' => $workout])
                </x-card>
            @endforeach
        </div>
        @endif

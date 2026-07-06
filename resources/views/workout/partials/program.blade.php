        <!-- ================= БЛОК: ПРОГРАММА (РОТАЦИЯ) ================= -->
        <div x-data="{ activeWorkout: null }" class="space-y-3.5">
            <x-h2>🔄 Программа (ротация)</x-h2>

            @forelse ($programWorkouts as $workout)
                <x-card class="bg-slate-900/60 border-slate-900 duration-200">
                    <div class="flex justify-between items-center gap-4">
                        <div class="cursor-pointer flex-1"
                            x-on:click="activeWorkout = activeWorkout === {{ $workout->id }} ? null : {{ $workout->id }}">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="px-2.5 py-0.5 rounded text-xs font-black uppercase tracking-wider border {{ $workout->status_color }}">
                                    {{ $workout->status_label }}
                                </span>
                            </div>
                            <x-h3 class="text-base mt-2.5 flex items-center gap-2">
                                <span>{{ $workout->title }}</span>
                                <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                    :class="activeWorkout === {{ $workout->id }} ? 'rotate-180' : ''">&#9660;</span>
                            </x-h3>
                            <x-p class="text-slate-400 mt-1.5">
                                @if ($workout->last_performed_at)
                                    Выполнялась: {{ $workout->last_performed_at->diffForHumans() }}
                                @else
                                    Еще ни разу не выполнялась
                                @endif
                            </x-p>
                        </div>
                        <form method="POST" action="{{ route('workouts.destroy', $workout->id) }}"
                            onsubmit="return confirm('Удалить эту программу тренировок?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-xl bg-slate-950 border border-slate-900 text-slate-400 hover:text-red-400 hover:border-red-900/30 flex items-center justify-center transition-colors cursor-pointer">
                                <span class="text-xs">✕</span>
                            </button>
                        </form>
                    </div>
                    @include('workout._exercise-list', ['workout' => $workout])
                </x-card>
            @empty
                <x-card class="bg-slate-900/20 border-slate-900/50 text-center py-12 px-6 space-y-4">
                    <span class="text-3xl block">📅</span>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Программы не созданы</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Создайте вашу первую тренировку или мгновенно загрузите готовую профессиональную программу!
                    </p>
                    <div class="pt-2">
                        <form method="POST" action="{{ route('workouts.seed_default') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-lg shadow-emerald-950/40 hover:-translate-y-0.5">
                                🚀 Загрузить PUSH / PULL / LEGS по умолчанию
                            </button>
                        </form>
                    </div>
                </x-card>
            @endforelse
        </div>

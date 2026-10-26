        <!-- ================= БЛОК: ПРОГРАММА (РОТАЦИЯ) ================= -->
        <div x-data="{ activeWorkout: null }" class="space-y-3.5">
            <x-h2>🔄 Программа (ротация)</x-h2>

            @forelse ($programWorkouts as $workout)
                <x-card class="bg-white border-slate-200/90 duration-200 shadow-sm">
                    <div class="flex justify-between items-center gap-4">
                        <div class="cursor-pointer flex-1"
                            x-on:click="activeWorkout = activeWorkout === {{ $workout->id }} ? null : {{ $workout->id }}">
                            <x-h3 class="text-base flex items-center gap-2 font-bold text-slate-900">
                                <span>{{ $workout->title }}</span>
                                <span class="text-xs text-slate-500 transform transition-transform duration-200"
                                    :class="activeWorkout === {{ $workout->id }} ? 'rotate-180' : ''">&#9660;</span>
                            </x-h3>
                            <x-p class="text-slate-600 mt-1">
                                @if ($workout->last_performed_at)
                                    Выполнялась: {{ $workout->last_performed_at->diffForHumans() }}
                                @else
                                    Еще ни разу не выполнялась
                                @endif
                            </x-p>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Кнопка редактирования -->
                            <button 
                                data-workout="{{ json_encode([
                                    'id' => $workout->id,
                                    'title' => $workout->title,
                                    'exercises' => $workout->exercises->map(function($ex) {
                                        return [
                                            'id' => $ex->id,
                                            'title' => $ex->title,
                                            'sets' => $ex->sets,
                                            'reps' => $ex->reps,
                                            'weight' => $ex->weight ?? '',
                                        ];
                                    })->toArray()
                                ]) }}"
                                @click="$dispatch('open-edit-workout-modal', JSON.parse($event.currentTarget.getAttribute('data-workout')))" 
                                class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-400/50 flex items-center justify-center transition-colors cursor-pointer shadow-sm" 
                                type="button" 
                                title="Редактировать">
                                <span class="text-xs">✏️</span>
                            </button>

                            <form method="POST" action="{{ route('workouts.destroy', $workout->id) }}"
                                onsubmit="return confirm('Удалить эту программу тренировок?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-300 flex items-center justify-center transition-colors cursor-pointer shadow-sm" title="Удалить">
                                    <span class="text-xs">✕</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @include('workout._exercise-list', ['workout' => $workout])
                </x-card>
            @empty
                <x-card class="bg-white/80 border-slate-200/80 text-center py-12 px-6 space-y-4">
                    <span class="text-3xl block">📅</span>
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Программы не созданы</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Создайте вашу первую тренировку или мгновенно загрузите готовую профессиональную программу!
                    </p>
                    <div class="pt-2">
                        <form method="POST" action="{{ route('workouts.seed_default') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-md shadow-emerald-600/20 hover:-translate-y-0.5">
                                🚀 Загрузить PULL / PUSH / LEGS по умолчанию
                            </button>
                        </form>
                    </div>
                </x-card>
            @endforelse
        </div>

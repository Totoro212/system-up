<x-app-layout title='Квесты'>

    <!-- Контейнер с реактивным стейтом для мгновенного обновления прогресса в реальном времени -->
    <div class='max-w-2xl mx-auto p-4 space-y-6' x-data="{
        completedCount: {{ $completedQuests }},
        totalCount: {{ $totalQuests }},
        showWorkout: false
    }">

        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <div>
                <x-h1>Мои квесты</x-h1>
                <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">
                    <span x-text="completedCount"></span> / <span x-text="totalCount"></span> Выполнено
                </x-p>
            </div>

            <x-primary-button x-data="" @click.prevent="$dispatch('open-modal', 'create-quest')">
                <span>+ Новый квест</span>
            </x-primary-button>
        </div>

        <!-- Уведомления об успехе (Success Alert) -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @include('quest.partials.quest-list')

        <!-- Секция тренировки под квестами -->
        <div class="space-y-4 pt-2">
            <div class="flex justify-center">
                <x-secondary-button @click.prevent="showWorkout = !showWorkout" class="w-full justify-center py-3 bg-slate-900/60 hover:bg-slate-900 border-slate-800 hover:border-indigo-500/30 transition-all duration-200">
                    <span class="flex items-center gap-2">🏋️ Сегодняшняя тренировка</span>
                </x-secondary-button>
            </div>

            <!-- Блок сегодняшней тренировки (inline) -->
            <div x-show="showWorkout" 
                 x-transition:enter="transition ease-out duration-250"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                 class="bg-slate-900/40 border border-slate-800/80 rounded-2xl p-5 space-y-4 shadow-xl backdrop-blur-md">
                
                @if ($todayWorkout)
                    <div class="flex justify-between items-start pb-3 border-b border-slate-800/60">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-400">Сегодняшняя тренировка</span>
                            <x-h2 class="text-base text-slate-100 mt-0.5">
                                {{ $todayWorkout->title }}
                            </x-h2>
                        </div>
                        <button @click="showWorkout = false" class="text-slate-400 hover:text-slate-200 text-xs p-1">
                            ✕
                        </button>
                    </div>

                    <!-- Список упражнений -->
                    <div class="grid gap-3 max-h-[350px] overflow-y-auto pr-1.5 custom-scrollbar">
                        @foreach ($todayWorkout->exercises as $exercise)
                            <div class="bg-slate-950/40 border border-slate-900 rounded-xl p-3.5 space-y-2">
                                <div class="flex justify-between items-start gap-2">
                                    <h4 class="font-bold text-sm text-slate-200">
                                        {{ $exercise->title }}
                                    </h4>
                                    <span class="px-2 py-0.5 rounded bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold whitespace-nowrap">
                                        {{ $exercise->sets }} × {{ $exercise->reps }}
                                    </span>
                                </div>

                                @if($exercise->weight)
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                                        <span>⚖️ Вес:</span>
                                        <span class="font-semibold text-slate-300">{{ $exercise->weight }}</span>
                                    </div>
                                @endif

                                @if($exercise->target_muscles)
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                                        <span>🎯 Мышцы:</span>
                                        <span class="font-semibold text-slate-300">{{ $exercise->target_muscles }}</span>
                                    </div>
                                @endif

                                @if($exercise->description)
                                    <div class="text-[11px] text-slate-500 whitespace-pre-line border-t border-slate-900/50 pt-1.5 mt-1.5">
                                        {{ $exercise->description }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-slate-800/60 mt-1">
                        <x-secondary-button @click="showWorkout = false">
                            Скрыть
                        </x-secondary-button>

                        <form method="POST" action="{{ route('workouts.complete', $todayWorkout->id) }}">
                            @csrf
                            <x-primary-button class="bg-emerald-500 hover:bg-emerald-600 focus:ring-emerald-500">
                                <span>Выполнено 💪</span>
                            </x-primary-button>
                        </form>
                    </div>
                @else
                    <div class="flex justify-between items-start pb-3 border-b border-slate-800/60">
                        <x-h2 class="text-sm text-slate-200">Сегодняшняя программа</x-h2>
                        <button @click="showWorkout = false" class="text-slate-400 hover:text-slate-200 text-xs p-1">
                            ✕
                        </button>
                    </div>
                    <div class="text-center py-6 space-y-3">
                        <span class="text-3xl block">🧘</span>
                        <x-h3 class="text-sm text-slate-100">Сегодня день отдыха</x-h3>
                        <x-p class="text-slate-400 max-w-sm mx-auto text-xs">
                            Вы выполнили все запланированные тренировки. Отдыхайте, восстанавливайтесь и копите силы для следующего цикла!
                        </x-p>
                    </div>
                @endif
            </div>
        </div>

        @include('quest.partials.modals')
    </div>
</x-app-layout>

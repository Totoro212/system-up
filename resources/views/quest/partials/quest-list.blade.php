        <!-- Список квестов -->
        <div class="space-y-4">
            <x-h2 class="mb-1.5">🎯 Активные квесты на сегодня</x-h2>

            @forelse ($quests as $quest)
                <div x-data="{ completed: {{ $quest->log_exists ? 'true' : 'false' }} }" class="relative group transition-all duration-300">

                    <form method="POST" action="{{ route('quest_complete', $quest->id) }}">
                        @csrf
                        <button type="submit"
                            @click.prevent="completed = !completed; completed ? completedCount++ : completedCount--; $el.closest('form').submit()"
                            style="-webkit-tap-highlight-color: transparent; outline: none !important; box-shadow: none !important;"
                            class="w-full text-left flex items-center gap-3.5 rounded-xl py-3 px-4 transition-all duration-200 cursor-pointer focus:outline-none active:outline-none focus-visible:outline-none select-none group/card"
                            :class="completed ?
                                'border border-l-2 border-slate-900/30 border-l-emerald-500/80 bg-slate-950/20 opacity-50 backdrop-blur-sm active:bg-slate-950/30 focus:border-slate-900/30 focus-visible:border-slate-900/30' :
                                'border border-l-2 border-slate-800/40 border-l-indigo-500/80 bg-slate-900/40 backdrop-blur-md hover:border-indigo-500/30 hover:bg-slate-900/50 active:bg-slate-900/60 hover:shadow-lg hover:shadow-indigo-950/10 focus:border-slate-800/40 focus-visible:border-slate-800/40'">

                            <!-- Интерактивный кастомный чекбокс -->
                            <div class="flex-shrink-0 w-5 h-5 rounded-md border flex items-center justify-center transition-all duration-200"
                                :class="completed ? 'bg-emerald-500/10 border-emerald-500/80' :
                                    'border-slate-700 group-hover/card:border-indigo-400 group-hover/card:bg-indigo-500/10'">
                                <!-- Птичка (для выполненного) -->
                                <svg x-show="completed" class="w-3 h-3 text-emerald-400 font-bold" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <!-- Точка предпросмотра (для активного при наведении) -->
                                <div x-show="!completed"
                                    class="w-2 h-2 bg-indigo-500 rounded-sm scale-0 group-hover/card:scale-100 transition-transform duration-200">
                                </div>
                            </div>

                            <div class="flex-grow pr-8">
                                <x-h3 class="transition-all duration-300 text-sm font-bold" x-bind:class="completed ? 'text-slate-500 line-through' : 'text-slate-100'">
                                    {{ $quest->title }}
                                </x-h3>

                            </div>
                        </button>
                    </form>

                    <!-- Кнопка удаления (для личных и системных квестов) -->
                    @if ($quest->user_id === null || $quest->user_id === auth()->id())
                        <form method="POST" action="{{ route('quests.destroy', $quest->id) }}"
                            class="absolute top-1/2 -translate-y-1/2 right-3 z-20 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200">
                            @csrf
                            @method('DELETE')
                            <x-danger-button class="w-7 h-7 px-0 py-0 flex items-center justify-center rounded-lg bg-slate-950/60 border border-slate-900 hover:bg-red-500/10 hover:border-red-500/20"
                                title="Удалить квест">
                                <span class="text-[10px] text-slate-400 hover:text-red-400">✕</span>
                            </x-danger-button>
                        </form>
                    @endif
                </div>
            @empty
                <x-card class="bg-slate-900/20 border-slate-900/50 text-center py-12 px-6 space-y-4">
                    <span class="text-3xl block">📭</span>
                    <x-h2>Список квестов пуст</x-h2>
                    <x-p class="text-slate-500 max-w-sm mx-auto">
                        Создайте ваш первый квест с помощью кнопки сверху или мгновенно загрузите ежедневные квесты по умолчанию!
                    </x-p>
                    <div class="pt-2">
                        <form method="POST" action="{{ route('quests.seed_default') }}">
                            @csrf
                            <x-primary-button>
                                🚀 Загрузить квесты по умолчанию
                            </x-primary-button>
                        </form>
                    </div>
                </x-card>
            @endforelse
        </div>

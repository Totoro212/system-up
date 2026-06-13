        <!-- ================= ВАЖНЫЕ ДАТЫ ================= -->
        <template x-if="currentTab === 'events'">
        <div class="space-y-6">
            <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
                <button @click="currentTab = 'hub'" 
                        class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                    <span>←</span>
                    <span>В Инструменты</span>
                </button>
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-event')">
                    <span>+</span>
                    <span>Добавить событие</span>
                </x-primary-button>
            </div>

                <div>
                    <x-h1>📅 Важные даты</x-h1>
                    <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Дни рождения, подписки и события</x-p>
                </div>

                <div class="space-y-3">
                    @forelse ($events ?? [] as $event)
                        @php
                            $colorClass = 'border-slate-800 bg-slate-900/40 text-slate-400';
                            $accentColor = 'text-slate-300';
                            if ($event->days_remaining === 0) {
                                $colorClass = 'border-red-500/50 bg-red-500/10 text-red-400 animate-pulse';
                                $accentColor = 'text-red-400';
                            } elseif ($event->days_remaining <= 3) {
                                $colorClass = 'border-red-500/30 bg-red-500/5 text-red-400';
                                $accentColor = 'text-red-400';
                            } elseif ($event->days_remaining <= 7) {
                                $colorClass = 'border-amber-500/30 bg-amber-500/5 text-amber-400';
                                $accentColor = 'text-amber-400';
                            }
                        @endphp
                        
                        <div class="relative group flex justify-between items-center p-4 rounded-xl border {{ $colorClass }} transition-colors duration-300">
                            <div class="flex items-center gap-4">
                                <span class="text-2xl">{{ $event->icon }}</span>
                                <div>
                                    <x-h3 class="{{ $accentColor }}">{{ $event->title }}</x-h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-mono font-bold">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d.m.Y') }}
                                        </span>
                                        @if($event->is_annual)
                                            <span class="text-[10px] uppercase tracking-widest font-black bg-slate-800 text-slate-400 px-1.5 py-0.5 rounded">Ежегодно</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="text-xl font-black block {{ $accentColor }}">
                                        @if($event->days_remaining === 0)
                                            СЕГОДНЯ!
                                        @else
                                            {{ $event->days_remaining }} <span class="text-xs uppercase tracking-widest">дн.</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 border-l border-slate-800 pl-4 ml-2">
                                    <!-- Кнопка редактирования -->
                                    <button type="button" @click="$dispatch('open-modal', 'edit-event-{{ $event->id }}')"
                                        class="w-8 h-8 px-0 py-0 flex items-center justify-center rounded-lg bg-slate-950/60 border border-slate-900 hover:bg-indigo-500/10 hover:border-indigo-500/30 text-slate-400 hover:text-indigo-400 cursor-pointer transition-colors"
                                        title="Редактировать">
                                        <span class="text-xs">✏️</span>
                                    </button>

                                    <!-- Кнопка удаления -->
                                    <form method="POST" action="{{ route('events.destroy', $event->id) }}" onsubmit="return confirm('Удалить событие?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="w-8 h-8 px-0 py-0 flex items-center justify-center rounded-lg bg-slate-950/60 border border-slate-900 hover:bg-red-500/10 hover:border-red-500/30 transition-colors"
                                            title="Удалить событие">
                                            <span class="text-[10px] text-slate-400 hover:text-red-400">✕</span>
                                        </x-danger-button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <x-card class="bg-slate-900/20 border-slate-900/50 text-center py-8 px-6">
                            <span class="text-3xl block opacity-50 mb-3">🗓️</span>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Нет предстоящих событий</h3>
                            <p class="text-xs text-slate-500">Добавьте важные даты, чтобы не забыть о них.</p>
                        </x-card>
                    @endforelse
                </div>
            </div>
        </template>

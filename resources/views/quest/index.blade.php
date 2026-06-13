<x-app-layout title='Квесты'>
    @php
        $totalQuests = count($quests);
        $completedQuests = $quests->where('log_exists', true)->count();
    @endphp
    <!-- Контейнер с реактивным стейтом для мгновенного обновления прогресса в реальном времени -->
    <div class='max-w-2xl mx-auto p-4 space-y-6' x-data="{
        completedCount: {{ $completedQuests }},
        totalCount: {{ $totalQuests }},
        get percent() {
            return this.totalCount > 0 ? Math.round((this.completedCount / this.totalCount) * 100) : 0;
        }
    }">

        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <div>
                <x-h1>Мои квесты</x-h1>
                <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">
                    <span x-text="completedCount"></span> / <span x-text="totalCount"></span> Выполнено
                </x-p>
            </div>

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-quest')">
                <span>+</span>
                <span>Новый квест</span>
            </x-primary-button>
        </div>

        <!-- Уведомления об успехе (Success Alert) -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Визуальный прогресс-бар выполнения -->
        <x-card>
            <div class="flex justify-between items-center mb-2.5">
                <x-h2 class="text-[10px]">📊 Прогресс дня</x-h2>
                <span class="text-xs font-black text-slate-200 font-mono"
                    x-text="completedCount + ' / ' + totalCount"></span>
            </div>
            <div class="w-full h-3 bg-slate-950/80 rounded-full overflow-hidden border border-slate-900/80">
                <div class="h-full rounded-full transition-all duration-500 ease-out"
                    :class="percent === 100 ?
                        'bg-gradient-to-r from-emerald-500 to-teal-400 shadow-[0_0_12px_rgba(16,185,129,0.3)]' :
                        'bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 shadow-[0_0_12px_rgba(99,102,241,0.3)]'"
                    :style="'width: ' + percent + '%'"></div>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-[10px] font-bold text-slate-500">0%</span>
                <span class="text-xs font-black transition-colors duration-300"
                    :class="percent === 100 ? 'text-emerald-400' : 'text-indigo-400'" x-text="percent + '%'"></span>
                <span class="text-[10px] font-bold text-slate-500">100%</span>
            </div>
        </x-card>

        @include('quest.partials.quest-list')

        @include('quest.partials.modals')
    </div>
</x-app-layout>

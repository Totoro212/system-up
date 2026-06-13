<x-app-layout title='Квесты'>

    <!-- Контейнер с реактивным стейтом для мгновенного обновления прогресса в реальном времени -->
    <div class='max-w-2xl mx-auto p-4 space-y-6' x-data="{
        completedCount: {{ $completedQuests }},
        totalCount: {{ $totalQuests }}
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

        @include('quest.partials.modals')
    </div>
</x-app-layout>

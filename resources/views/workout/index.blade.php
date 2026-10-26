<x-app-layout title='Тренировки'>
    <!-- Контейнер расширен до max-w-2xl для идеального баланса и простора на любых экранах -->
    <div class='max-w-2xl mx-auto p-4 space-y-6'>
                    <a href="{{ route('tools') }}"
                       class="text-[10px] font-extrabold text-indigo-600 hover:text-indigo-500 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-white px-3.5 py-2 rounded-xl border border-slate-200 hover:border-indigo-400 hover:-translate-y-0.5 transition-all w-fit shadow-sm">
                        <span>←</span>
                        <span>В Инструменты</span>
                    </a>
        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center border-b border-slate-200 pb-2">
            <x-h1>🏋️ Тренировки</x-h1>

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-workout')">
                <span>+</span>
                <span>Создать план</span>
            </x-primary-button>
        </div>

        <!-- Уведомления об успехе -->
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-xs font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @include('workout.partials.program')

        @include('workout.partials.modals')

    </div>
</x-app-layout>

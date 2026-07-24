<x-app-layout title='Тренировки'>
    <!-- Контейнер расширен до max-w-2xl для идеального баланса и простора на любых экранах -->
    <div class='max-w-2xl mx-auto p-4 space-y-6'>
                    <a href="{{ route('tools') }}"
                       class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all w-fit">
                        <span>←</span>
                        <span>В Инструменты</span>
                    </a>
        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <div>
                <x-h1>🏋️ Тренировки</x-h1>
                <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Программа: {{ $totalProgramWorkouts }} тренировок в ротации</x-p>
            </div>
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-workout')">
                <span>+</span>
                <span>Создать план</span>
            </x-primary-button>
        </div>

        <!-- Уведомления об успехе -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @include('workout.partials.today')
        @include('workout.partials.program')

        @include('workout.partials.modals')

    </div>
</x-app-layout>

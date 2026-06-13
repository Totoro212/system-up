<template x-if="currentTab === 'finance'">
<div class="space-y-6">
    <!-- Навигационная панель назад -->
    <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
        <button @click="currentTab = 'hub'" 
                class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
            <span>←</span>
            <span>В Инструменты</span>
        </button>
        <div class="space-x-2">
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-income')" class="bg-emerald-600 hover:bg-emerald-500">
                <span>+</span><span>Доход</span>
            </x-primary-button>
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-expense')" class="bg-rose-600 hover:bg-rose-500">
                <span>-</span><span>Расход</span>
            </x-primary-button>
        </div>
    </div>

<x-card class="mb-6">
    <div class="flex justify-between items-center mb-6">
        <x-h2>🎯 Виртуальные фонды (50/40/10)</x-h2>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-funds')" class="text-xs text-slate-500 hover:text-indigo-400 transition-colors uppercase tracking-widest font-bold">
            Изменить %
        </button>
    </div>

    <div class="space-y-5">
        @forelse($funds as $fund)
            <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700/50">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <span class="text-xl mr-2">{{ $fund->icon ?? '💰' }}</span>
                        <div>
                            <div class="font-bold text-slate-200 text-sm">{{ $fund->name }}</div>
                            @if($fund->target_percentage)
                                <div class="text-[10px] text-slate-500 font-mono tracking-wider">ЦЕЛЬ: {{ $fund->target_percentage }}% ОТ ДОХОДА</div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-mono font-black text-lg {{ $fund->color ? 'text-'.$fund->color.'-400' : 'text-white' }}">
                            {{ number_format($fund->balance, 0, '.', ' ') }} <span class="text-xs text-slate-500">{{ $fund->currency }}</span>
                        </div>
                    </div>
                </div>
                <!-- Визуальная полоса веса фонда -->
                @if($fund->target_percentage)
                    <div class="mt-4 w-full h-1.5 bg-slate-950 rounded-full overflow-hidden">
                        <div class="h-full {{ $fund->color ? 'bg-'.$fund->color.'-400' : 'bg-slate-400' }} rounded-full opacity-80"
                             style="width: {{ $fund->target_percentage }}%"></div>
                    </div>
                @else
                    <div class="mt-4 w-full h-1.5 bg-slate-950 rounded-full overflow-hidden">
                        <div class="h-full {{ $fund->color ? 'bg-'.$fund->color.'-400' : 'bg-slate-400' }} rounded-full opacity-50"
                             style="width: 100%"></div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-sm text-slate-500 text-center py-4">Нет добавленных фондов</div>
        @endforelse
    </div>
</x-card>

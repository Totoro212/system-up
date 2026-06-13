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
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-funds')" class="bg-slate-800 text-slate-300 hover:bg-slate-700">
                <span>⚙️</span><span class="hidden sm:inline"> Настроить %</span>
            </x-primary-button>
        </div>
    </div>

    <!-- Сводка -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-5">
            <div class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-1">Всего денег (Капитал)</div>
            @foreach($totalCapital as $currency => $amount)
                <div class="text-xl font-bold text-slate-100">{{ number_format($amount, 0, '.', ' ') }} <span class="text-sm text-indigo-300">{{ $currency }}</span></div>
            @endforeach
        </div>
        <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-5">
            <div class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Распределено по фондам</div>
            @foreach($totalFunds as $currency => $amount)
                <div class="text-xl font-bold text-slate-100">{{ number_format($amount, 0, '.', ' ') }} <span class="text-sm text-emerald-300">{{ $currency }}</span></div>
            @endforeach
        </div>
    </div>

    <!-- Главные кнопки -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-income')" class="bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl py-4 flex flex-col items-center justify-center transition-all shadow-lg hover:-translate-y-1">
            <span class="text-2xl mb-1">📥</span>
            <span class="text-xs font-bold uppercase tracking-wider">Получил</span>
        </button>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-expense')" class="bg-rose-600 hover:bg-rose-500 text-white rounded-xl py-4 flex flex-col items-center justify-center transition-all shadow-lg hover:-translate-y-1">
            <span class="text-2xl mb-1">💸</span>
            <span class="text-xs font-bold uppercase tracking-wider">Потратил</span>
        </button>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'transfer-money')" class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl py-4 flex flex-col items-center justify-center transition-all shadow-lg hover:-translate-y-1">
            <span class="text-2xl mb-1">🔁</span>
            <span class="text-xs font-bold uppercase tracking-wider">Перевёл</span>
        </button>
    </div>

    <!-- Мои Бюджеты (Фонды) -->
    <x-card class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <x-h2>🎯 Мои Бюджеты (На что тратить)</x-h2>
        </div>

        <div class="space-y-4">
            @forelse($funds as $fund)
                <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700/50">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">{{ $fund->icon ?? '💰' }}</span>
                            <div>
                                <div class="font-bold text-slate-200 text-sm">{{ $fund->name }}</div>
                                @if($fund->target_percentage)
                                    <div class="text-[10px] text-slate-500 font-mono tracking-wider">ЛИМИТ: {{ $fund->target_percentage }}% ОТ ДОХОДА</div>
                                @else
                                    <div class="text-[10px] text-slate-500 font-mono tracking-wider">ВРУЧНУЮ (0%)</div>
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
                        <div class="mt-3 w-full h-1.5 bg-slate-950 rounded-full overflow-hidden">
                            <div class="h-full {{ $fund->color ? 'bg-'.$fund->color.'-400' : 'bg-slate-400' }} rounded-full opacity-80"
                                style="width: {{ $fund->target_percentage }}%"></div>
                        </div>
                    @else
                        <div class="mt-3 w-full h-1.5 bg-slate-950 rounded-full overflow-hidden">
                            <div class="h-full {{ $fund->color ? 'bg-'.$fund->color.'-400' : 'bg-slate-400' }} rounded-full opacity-30"
                                style="width: 100%"></div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-sm text-slate-500 text-center py-4">Нет добавленных фондов</div>
            @endforelse
        </div>
    </x-card>

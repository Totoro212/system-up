<!-- ================= ЭКРАН 3: ФИНАНСЫ (УПРОЩЕННЫЙ) ================= -->
<template x-if="currentTab === 'finance'">
    <div class="space-y-6 max-w-2xl mx-auto pb-20">

        <!-- Шапка -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-900/50">
            <button @click="currentTab = 'hub'"
                class="self-start text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                <span>←</span>
                <span>В Инструменты</span>
            </button>
            <div class="text-center sm:text-right">
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500 mb-1">Ваш Капитал
                    (Сбережения)</p>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-emerald-400 drop-shadow-[0_0_15px_rgba(16,185,129,0.1)] relative z-10 break-all sm:break-normal">
                    {{ number_format($totalBalance, 0, '', ' ') }} <span
                        class="text-lg sm:text-xl text-slate-500 font-bold ml-1">UZS</span>
                </h1>
            </div>
        </div>


        <!-- Общий баланс -->


        <!-- Конверты (50/30/20) -->
        <div class="space-y-4 ">
            <div class="flex items-center justify-between px-1 mb-2">
                <x-h3 class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest">Разделение
                    дохода</x-h3>

                <form method="POST" action="{{ route('finance.budget.reset') }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Вы уверены, что хотите начать новый учетный месяц и обнулить эти суммы? (Капитал не пострадает)')"
                        class="text-[10px] text-slate-500 hover:text-rose-400 font-extrabold uppercase tracking-widest flex items-center gap-1 transition-colors bg-slate-900/50 hover:bg-slate-800 px-2 py-1 rounded border border-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Новый доход
                    </button>
                </form>
            </div>

            @if (isset($envelopes) && $envelopes->count() > 0)
                @foreach ($envelopes as $envelope)
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-5 relative overflow-hidden">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-{{ $envelope->color_class }}-500/5 rounded-full blur-2xl pointer-events-none">
                        </div>

                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Баланс и Инфо -->
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span
                                        class="text-[10px] font-bold text-{{ $envelope->color_class }}-400 bg-slate-950 px-2 py-0.5 rounded border border-slate-800">
                                        {{ $envelope->percentage }}%
                                    </span>
                                    <h3 class="text-sm font-bold text-slate-200">{{ $envelope->name }}</h3>
                                </div>
                                <div class="text-2xl font-black text-white">
                                    {{ number_format($envelope->monthly_budget, 0, '', ' ') }}
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">UZS /
                                        Мес</span>
                                </div>
                                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1">
                                    @if ($envelope->slug === 'savings')
                                        Отложено в этом месяце
                                    @else
                                        Бюджет на этот месяц
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Пополнение (Доход) -->
        <div class="pt-4">
            <x-card class="bg-slate-900/40 border-slate-800/60 p-6 shadow-2xl relative overflow-hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none">
                </div>

                <form method="POST" action="{{ route('finance.income.store') }}" class="relative z-10 space-y-4">
                    @csrf
                    <div class="text-center space-y-4" x-data="{
                        rawAmount: '',
                        get formattedAmount() {
                            if (!this.rawAmount) return '';
                            return this.rawAmount.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                        },
                        setAmount(val) {
                            this.rawAmount = val.replace(/\D/g, '');
                        },
                        addAmount(amount) {
                            let current = parseInt(this.rawAmount || 0);
                            this.rawAmount = (current + amount).toString();
                        }
                    }">
                        <label for="income_amount"
                            class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Поступление
                            дохода</label>
                        <!-- Поле ввода -->
                        <div class="relative flex items-center justify-center">
                            <input type="text" id="income_amount" placeholder="0" required autocomplete="off"
                                :value="formattedAmount" @input="setAmount($event.target.value)"
                                :class="rawAmount.length >= 8 ? 'text-3xl sm:text-5xl' : (rawAmount.length >= 5 ?
                                    'text-4xl sm:text-6xl' : 'text-5xl sm:text-7xl')"
                                class="bg-transparent border-none text-center font-black text-slate-100 placeholder-slate-800 focus:ring-0 w-full appearance-none transition-all duration-200"
                                style="-moz-appearance: textfield;">
                            <input type="hidden" name="amount" :value="rawAmount">
                        </div>

                        <!-- Быстрые кнопки добавления -->
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <button type="button" @click="addAmount(100000)"
                                class="px-3 py-2 rounded-lg bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 text-slate-300 text-xs font-bold transition-all hover:scale-105 active:scale-95">+
                                100k</button>
                            <button type="button" @click="addAmount(500000)"
                                class="px-3 py-2 rounded-lg bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 text-slate-300 text-xs font-bold transition-all hover:scale-105 active:scale-95">+
                                500k</button>
                            <button type="button" @click="addAmount(1000000)"
                                class="px-3 py-2 rounded-lg bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 text-slate-300 text-xs font-bold transition-all hover:scale-105 active:scale-95">+
                                1M</button>
                            <button type="button" @click="addAmount(5000000)"
                                class="px-3 py-2 rounded-lg bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 text-slate-300 text-xs font-bold transition-all hover:scale-105 active:scale-95">+
                                5M</button>
                            <button type="button" @click="rawAmount = ''" x-show="rawAmount.length > 0"
                                class="px-3 py-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 text-xs font-bold transition-all"
                                title="Очистить">✕</button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-slate-950/50 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/10 hover:border-emerald-500/40 transition-all font-extrabold uppercase tracking-widest text-[11px] shadow-lg shadow-emerald-950/20">
                        <span class="text-lg">📈</span> Распределить (50/30/20)
                    </button>
                </form>
            </x-card>
        </div>

        <!-- Управление Капиталом -->
        <div class="pt-8 mt-4 border-t border-slate-900/50">
            <details class="group">
                <summary
                    class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest cursor-pointer list-none flex items-center justify-center gap-2 hover:text-indigo-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    Управление капиталом (Покупка / Проценты)
                </summary>
                <div class="mt-4 animate-fade-in">
                    <form method="POST" action="{{ route('finance.capital.adjust') }}"
                        class="flex flex-col sm:flex-row items-center gap-2 bg-slate-900/40 p-4 rounded-xl border border-slate-800 shadow-inner">
                        @csrf
                        <select name="operation" required
                            class="w-full sm:w-auto bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 focus:border-indigo-500/50 focus:ring-0 transition-all font-medium appearance-none cursor-pointer">
                            <option value="sub">➖ Изъять (Покупка)</option>
                            <option value="add">➕ Добавить (Проценты)</option>
                        </select>

                        <input type="number" name="amount" required placeholder="Сумма"
                            class="w-full sm:w-1/3 bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:border-indigo-500/50 focus:ring-0 transition-all font-medium text-right"
                            style="-moz-appearance: textfield;">

                        <button type="submit"
                            class="w-full sm:flex-1 shrink-0 flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 transition-all font-bold text-sm">
                            Сохранить
                        </button>
                    </form>
                </div>
            </details>
        </div>

    </div>
</template>

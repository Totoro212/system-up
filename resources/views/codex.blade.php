@extends('layouts.app')

@section('content')
    <!-- Контейнер расширен до max-w-2xl для идеальной гармонии с тренировками и квестами -->
    <div class="max-w-2xl mx-auto p-4 space-y-6 pb-20" x-data="{ activeCategory: null }">

        <!-- Заголовок страницы -->
        <div class="pb-4 border-b border-slate-900/50">
            <h1 class="text-2xl font-black tracking-wider text-slate-100 uppercase">📜 Кодекс Охотника</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">
                Свод железных правил личной дисциплины и ментальных моделей
            </p>
        </div>

        <!-- ================= БЛОК: STOIC DAILY (СТОИЦИЗМ НА ДЕНЬ) ================= -->
        @if ($stoicQuote)
            <div class="bg-slate-900/40 border border-indigo-500/20 backdrop-blur-md rounded-2xl p-6 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>
                
                <!-- Шапка карточки -->
                <div class="flex justify-between items-center gap-4">
                    <span class="text-[10px] font-extrabold text-indigo-400 uppercase tracking-widest block">⚔️ STOIC DAILY</span>
                    
                    <!-- Кнопка добавления цитаты -->
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-stoic-quote')" 
                            class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1">
                        <span>➕</span>
                        <span>Добавить цитату</span>
                    </button>
                </div>

                <!-- Текст цитаты -->
                <p class="text-sm text-slate-100 font-sans italic leading-relaxed mt-3.5 mb-2">
                    «{{ $stoicQuote->text }}»
                </p>

                <!-- Разделитель и Практика дня -->
                @if ($stoicQuote->practice)
                    <div class="border-t border-slate-950 mt-4 pt-4 text-xs text-slate-300 leading-relaxed font-sans">
                        {{ $stoicQuote->practice }}
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= РАЗДЕЛ 1: БАЗОВЫЕ ПРАВИЛА ================= -->
        <div class="space-y-3.5">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">⚔️ Базовый кодекс жизни</h2>

            <div class="grid grid-cols-1 gap-3.5">
                @foreach ($baseCodex as $index => $cat)
                    @php $catId = $index + 1; @endphp
                    <div class="bg-slate-900/40 border border-slate-800/40 backdrop-blur-md rounded-2xl p-5 shadow-lg shadow-indigo-950/10 hover:border-indigo-500/30 transition-all duration-300">
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === {{ $catId }} ? null : {{ $catId }}">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">{{ $cat['icon'] }}</span>
                                <div>
                                    <h3 class="text-sm font-black text-slate-100 uppercase tracking-wide">{{ $cat['title'] }}</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $cat['description'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === {{ $catId }} ? 'rotate-180' : ''">▼</span>
                        </div>

                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === {{ $catId }}" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-3">
                            @foreach ($cat['rules'] as $rule)
                                <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900 flex gap-3 items-start">
                                    <span class="text-indigo-400 text-xs font-bold mt-0.5">⚡</span>
                                    <p class="text-xs text-slate-200 leading-relaxed font-sans">{{ $rule }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ================= РАЗДЕЛ 2: ПРОДВИНУТЫЕ ЗНАНИЯ ================= -->
        <div class="space-y-3.5 pt-4">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">📐 Тайные свитки и архитектура систем</h2>

            <div class="grid grid-cols-1 gap-3.5">
                @foreach ($advancedCodex as $index => $cat)
                    @php $catId = $index + 100; @endphp
                    <div class="bg-slate-900/40 border border-slate-800/40 backdrop-blur-md rounded-2xl p-5 shadow-lg shadow-indigo-950/10 hover:border-indigo-500/30 transition-all duration-300">
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === {{ $catId }} ? null : {{ $catId }}">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">{{ $cat['icon'] }}</span>
                                <div>
                                    <h3 class="text-sm font-black text-indigo-300 uppercase tracking-wide">{{ $cat['title'] }}</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $cat['description'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === {{ $catId }} ? 'rotate-180' : ''">▼</span>
                        </div>

                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === {{ $catId }}" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-3">
                            @foreach ($cat['rules'] as $rule)
                                <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900 flex gap-3 items-start">
                                    <span class="text-emerald-400 text-xs font-bold mt-0.5">🌟</span>
                                    <p class="text-xs text-slate-200 leading-relaxed font-sans">{{ $rule }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Модальное окно создания стоической цитаты -->
    <x-modal name="create-stoic-quote" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-base font-bold text-slate-100 uppercase tracking-wider mb-4 pb-2 border-b border-slate-800/80">Добавить стоическую цитату</h2>
            
            <form method="POST" action="{{ route('stoic_quotes.store') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="stoic_text" class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Высказывание / Цитата</label>
                    <textarea name="text" id="stoic_text" required rows="3" placeholder="Например: Смерти не следует бояться, ведь когда мы есть — её нет, а когда она есть — нас нет."
                              class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors font-sans leading-relaxed"></textarea>
                    <x-input-error :messages="$errors->get('text')" class="mt-1" />
                </div>
                
                <div>
                    <label for="stoic_practice" class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Практика дня / Размышление</label>
                    <textarea name="practice" id="stoic_practice" rows="2" placeholder="Например: 📌 Практика дня: Подумай о том, что большинство твоих страхов существуют только в твоей голове."
                              class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors font-sans leading-relaxed"></textarea>
                    <x-input-error :messages="$errors->get('practice')" class="mt-1" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button x-on:click="$dispatch('close')" type="button">
                        Отмена
                    </x-secondary-button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs tracking-wider uppercase transition-all cursor-pointer">
                        Добавить в свитки
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection

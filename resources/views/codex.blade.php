@extends('layouts.app')

@section('content')
    <!-- Контейнер расширен до max-w-2xl для идеальной гармонии с тренировками и квестами -->
    <div class="max-w-2xl mx-auto p-4 space-y-6" x-data="{ activeCategory: null }">

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

        <!-- ================= БЛОК: 5 СТОЛПОВ СЧАСТЬЯ ================= -->
        <div x-data="{ activePillar: 'health' }" class="bg-slate-900/40 border border-slate-800/40 backdrop-blur-md rounded-2xl p-5 shadow-lg shadow-indigo-950/10 space-y-4">
            
            <!-- Заголовок блока -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-950">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">🧭 5 Столпов Счастья (Путь к балансу)</span>
                <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-wider">Интерактивный Баланс</span>
            </div>

            <!-- Сетка 5-ти плиток -->
            <div class="grid grid-cols-5 gap-2 sm:gap-3">
                
                <!-- Здоровье -->
                <button type="button" @click="activePillar = 'health'"
                        class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                        :class="activePillar === 'health' 
                            ? 'bg-emerald-500/10 border-emerald-500/50 shadow-[0_0_15px_rgba(16,185,129,0.15)] text-emerald-400 scale-[1.03]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🏥</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Здоровье</span>
                </button>

                <!-- Безопасность -->
                <button type="button" @click="activePillar = 'security'"
                        class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                        :class="activePillar === 'security' 
                            ? 'bg-blue-500/10 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.15)] text-blue-400 scale-[1.03]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🛡️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Защита</span>
                </button>

                <!-- Свобода -->
                <button type="button" @click="activePillar = 'freedom'"
                        class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                        :class="activePillar === 'freedom' 
                            ? 'bg-violet-500/10 border-violet-500/50 shadow-[0_0_15px_rgba(139,92,246,0.15)] text-violet-400 scale-[1.03]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🕊️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Свобода</span>
                </button>

                <!-- Близкие -->
                <button type="button" @click="activePillar = 'family'"
                        class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                        :class="activePillar === 'family' 
                            ? 'bg-rose-500/10 border-rose-500/50 shadow-[0_0_15px_rgba(244,63,94,0.15)] text-rose-400 scale-[1.03]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">❤️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Близкие</span>
                </button>

                <!-- Любимое дело -->
                <button type="button" @click="activePillar = 'work'"
                        class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                        :class="activePillar === 'work' 
                            ? 'bg-amber-500/10 border-amber-500/50 shadow-[0_0_15px_rgba(245,158,11,0.15)] text-amber-400 scale-[1.03]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🎯</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Дело</span>
                </button>

            </div>

            <!-- Детализация выбранного Столпа (Свитки мудрости) -->
            <div class="mt-4">
                
                <!-- Описание Здоровья -->
                <div x-show="activePillar === 'health'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-emerald-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-emerald-400">
                        <span class="text-lg">🏥</span>
                        <h3 class="text-xs font-black uppercase tracking-wider">Здоровье — Фундамент Биокомпьютера</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-sans">
                        Помни золотое правило: <span class="text-emerald-400 font-semibold">«Здоровье — это твой главный физический капитал»</span>. Твое тело — это биологический компьютер. Если он зависает или перегревается, никакие успехи в бизнесе или делах не принесут счастья.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-emerald-400">🔋</span>
                            <span><strong>Закон энергии:</strong> Твое счастье напрямую зависит от количества энергии. Заряжай батарею: качественный сон (7-8 часов), чистая вода и спорт.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-emerald-400">⚖️</span>
                            <span><strong>Стоический взгляд:</strong> Тело — это «предпочтительное безразличное». Оно не подконтрольно разуму целиком, но забота о нем — долг мудреца.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-emerald-950/20 border border-emerald-500/15 p-3 rounded-lg col-span-1 sm:col-span-2 text-slate-300">
                            <span class="text-emerald-400">🧠</span>
                            <span><strong>Нейробиология счастья:</strong> Физические упражнения, здоровое питание и достаточный сон напрямую способствуют активной выработке гормонов счастья (дофамина, серотонина, эндорфинов). Это биологический фундамент твоей продуктивности!</span>
                        </div>
                    </div>
                </div>

                <!-- Описание Безопасности -->
                <div x-show="activePillar === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-blue-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-blue-400">
                        <span class="text-lg">🛡️</span>
                        <h3 class="text-xs font-black uppercase tracking-wider">Безопасность — Спокойствие Духа</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-sans">
                        Дисциплинированный разум знает: настоящая безопасность — это <span class="text-blue-400 font-semibold">«отсутствие постоянного страха за завтрашний день»</span>. Это финансовая, физическая и психологическая защита, которая избавляет мозг от стресса выживания.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-blue-400">💰</span>
                            <span><strong>Подушка безопасности:</strong> Финансовый резерв минимум на 6 месяцев жизни дает тебе право выбора и избавляет от паники перед кризисами.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-blue-400">🧘</span>
                            <span><strong>Стоический взгляд:</strong> Настоящая безопасность — это Атараксия (невозмутимость). Понимание того, что внешние события не могут ранить твою душу.</span>
                        </div>
                    </div>
                </div>

                <!-- Описание Свободы -->
                <div x-show="activePillar === 'freedom'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-violet-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-violet-400">
                        <span class="text-lg">🕊️</span>
                        <h3 class="text-xs font-black uppercase tracking-wider">Свобода — Независимость Выбора</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-sans">
                        Свобода — это важнейший множитель счастья: <span class="text-violet-400 font-semibold">«Свобода — это возможность не делать то, чего ты делать не хочешь»</span>. Свобода от чужих ожиданий, долгов и навязанного мнения.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-violet-400">🚫</span>
                            <span><strong>Умей говорить «Нет»:</strong> Не соглашайся на дела и людей, которые крадут твою энергию. Защита своего времени — это основа суверенитета личности.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-violet-400">🔑</span>
                            <span><strong>Стоический взгляд:</strong> Свобода — это власть разума над страстями. Свободен тот, кто желает лишь того, что находится в его полной воле.</span>
                        </div>
                    </div>
                </div>

                <!-- Описание Близких -->
                <div x-show="activePillar === 'family'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-rose-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-rose-400">
                        <span class="text-lg">❤️</span>
                        <h3 class="text-xs font-black uppercase tracking-wider">Близкие Люди — Тепло и Окружение</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-sans">
                        Человек — существо социальное. В Кодексе записано: <span class="text-rose-400 font-semibold">«Отношения — это сад, его нужно поливать каждый день»</span>. Окружай себя донаторами энергии, цени верность и дари любовь в ответ.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-rose-400">🌱</span>
                            <span><strong>Качество, а не количество:</strong> Достаточно иметь 3–5 глубоких, искренних связей. Избавляйся от токсичных отношений («вампиров»), сосущих твой ресурс.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-rose-400">🤝</span>
                            <span><strong>Стоический взгляд:</strong> Мы рождены друг для друга (Сенека). Заботься об общем благе и поддерживай близких — в этом проявляется справедливость.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-rose-950/20 border border-rose-500/15 p-3 rounded-lg col-span-1 sm:col-span-2 text-slate-300">
                            <span class="text-rose-400">🧠</span>
                            <span><strong>Нейробиология счастья:</strong> Крепкие социальные связи запускают мощную выработку окситоцина (гормона доверия, спокойствия и привязанности). Общение с любимыми снижает стресс на биологическом уровне.</span>
                        </div>
                    </div>
                </div>

                <!-- Описание Любимого Дела -->
                <div x-show="activePillar === 'work'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-amber-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-amber-400">
                        <span class="text-lg">🎯</span>
                        <h3 class="text-xs font-black uppercase tracking-wider">Любимое Дело — Поток и Полезность</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-sans">
                        Любимое дело дает ключевое чувство: <span class="text-amber-400 font-semibold">«осознание нужности своего существования»</span>. Это работа в состоянии Потока, когда ты сфокусирован на пользе людям и качестве процесса, а не только на деньгах.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-amber-400">🎯</span>
                            <span><strong>Философия Kaizen:</strong> Маленькие шаги (+1% в день) в твоем ремесле ведут к величию. Кайфуй от процесса оттачивания мастерства.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-amber-400">🛠️</span>
                            <span><strong>Стоический взгляд:</strong> Делай то, что велит твой долг и природа, делай это превосходно (Арете) на благо всего общества.</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>


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

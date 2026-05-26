@extends('layouts.app')

@section('content')
    <!-- Контейнер расширен до max-w-2xl для идеального баланса и простора на любых экранах -->
    <div class='max-w-2xl mx-auto p-4 space-y-6'>

        <!-- Заголовок страницы -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <div>
                <h1 class="text-2xl font-black tracking-wider text-slate-100 uppercase">Расписание</h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Сегодня: {{ $todayDayOfWeek }}</p>
            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-workout')"
                class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-lg shadow-indigo-950/40 hover:-translate-y-0.5">
                <span>+</span>
                <span>Создать план</span>
            </button>
        </div>

        <!-- Уведомления об успехе -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- ================= БЛОК: СЕГОДНЯ В РАСПИСАНИИ ================= -->
        <div>
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Сегодня в плане</h2>

            @if ($todayWorkout)
                <div class="bg-slate-900 border-2 border-indigo-500/30 rounded-2xl p-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>

                    <!-- Шапка -->
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <span class="text-xs font-extrabold text-indigo-400 uppercase tracking-widest block">⭐
                                ТРЕНИРОВКА НА СЕГОДНЯ</span>
                            <h3 class="text-xl font-black text-slate-100 uppercase tracking-wide mt-1">
                                {{ $todayWorkout->title }}</h3>
                        </div>

                        <!-- Статус тонуса -->
                        <span
                            class="px-3 py-1 rounded-lg border text-xs font-black uppercase tracking-wider {{ $todayWorkout->status_color }}">
                            {{ $todayWorkout->status_label }}
                        </span>
                    </div>

                    <!-- Форма выполнения тренировки с записью рабочих весов -->
                    <form method="POST" action="{{ route('workouts.complete', $todayWorkout->id) }}">
                        @csrf

                        <!-- Список упражнений на сегодня -->
                        <div class="mt-6 space-y-4">
                            @foreach ($todayWorkout->exercises as $exercise)
                                <div class="bg-slate-950/50 border border-slate-900/60 rounded-xl p-4">
                                    <div class="flex justify-between items-center flex-wrap gap-2">
                                        <h4 class="text-sm font-black text-slate-100 uppercase tracking-wide">
                                            {{ $exercise->title }}</h4>
                                        <span
                                            class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/5 px-2.5 py-1 rounded border border-emerald-500/10">
                                            {{ $exercise->sets }} × {{ $exercise->reps }}
                                        </span>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mt-2.5">
                                        @if ($exercise->target_muscles)
                                            <span
                                                class="text-xs font-bold text-slate-300 bg-slate-800/60 px-2.5 py-0.5 rounded">
                                                🎯 {{ $exercise->target_muscles }}
                                            </span>
                                        @endif
                                        @if ($exercise->weight)
                                            <span
                                                class="text-xs font-bold text-amber-400 bg-amber-500/5 px-2.5 py-0.5 rounded border border-amber-500/10">
                                                💪 {{ $exercise->weight }}
                                            </span>
                                        @endif

                                        <!-- Бейдж прогрессии -->
                                        @if ($exercise->progression_status !== 'new')
                                            <span class="text-xs font-bold px-2.5 py-0.5 rounded border {{ $exercise->progression_color }}">
                                                📈 {{ $exercise->progression_label }}
                                            </span>
                                        @endif

                                        <!-- Рекомендация при стагнации или регрессе -->
                                        @if ($exercise->suggested_weight)
                                            <span class="text-xs font-bold text-amber-300 bg-amber-500/5 px-2.5 py-0.5 rounded border border-amber-400/20 animate-pulse">
                                                ⚡ Рекомендуем: {{ $exercise->suggested_weight }} кг
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Инпут для ввода рабочего веса -->
                                    <div class="mt-3 flex items-center gap-2">
                                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest whitespace-nowrap">Вес (кг):</label>
                                        <input type="number" 
                                               name="weights[{{ $exercise->id }}]" 
                                               step="0.5" 
                                               min="0" 
                                               max="500"
                                               placeholder="{{ $exercise->suggested_weight ?? $exercise->last_weight ?? 'кг' }}"
                                               value="{{ $exercise->last_weight }}"
                                               class="w-full bg-slate-950 border border-slate-900 rounded-lg px-3 py-2 text-xs text-slate-200 font-mono placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    @if ($exercise->description)
                                        <p
                                            class="text-xs text-slate-300 mt-3 leading-relaxed bg-slate-950 p-3 rounded-lg border border-slate-850/80 font-sans whitespace-pre-line">
                                            {{ $exercise->description }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Кнопка «Выполнить тренировку» -->
                        <button type="submit"
                            class="w-full mt-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-widest shadow-lg shadow-indigo-950/50 hover:shadow-indigo-500/20 transition-all duration-200 cursor-pointer flex items-center justify-center gap-2">
                            <span>✅</span>
                            <span>Выполнить и записать веса</span>
                        </button>
                    </form>
                </div>
            @else
                <!-- День отдыха -->
                <div
                    class="bg-slate-900/40 border border-slate-900 rounded-2xl p-8 text-center shadow-lg relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
                    <span class="text-3xl block">✨</span>
                    <h3 class="text-sm font-black text-slate-200 uppercase tracking-widest mt-2.5">Сегодня день отдыха!</h3>
                    <p class="text-xs text-slate-400 mt-1.5 max-w-[280px] mx-auto leading-relaxed">
                        Отличный день, чтобы восстановить мышцы, выспаться или выполнить пару новых ежедневных квестов!
                    </p>
                </div>
            @endif
        </div>

        <!-- ================= БЛОК: ВСЕ ПРОГРАММЫ ================= -->
        <div x-data="{ activeWorkout: null }" class="space-y-3.5">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Мои программы</h2>

            @forelse ($workouts as $workout)
                <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-5 shadow-lg transition-all duration-200">

                    <div class="flex justify-between items-center gap-4">
                        <!-- Клик для раскрытия списка упражнений -->
                        <div class="cursor-pointer flex-1"
                            x-on:click="activeWorkout = activeWorkout === {{ $workout->id }} ? null : {{ $workout->id }}">
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if (is_array($workout->day_of_week) && count($workout->day_of_week) > 0)
                                    @foreach ($workout->day_of_week as $day)
                                        <span class="text-xs font-bold text-slate-300 bg-slate-800 px-2.5 py-0.5 rounded">
                                            📅 {{ $day }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-xs font-bold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded">
                                        📅 Вне плана
                                    </span>
                                @endif

                                <!-- Индикатор состояния -->
                                <span
                                    class="px-2.5 py-0.5 rounded text-xs font-black uppercase tracking-wider border {{ $workout->status_color }}">
                                    {{ $workout->status_label }}
                                </span>
                            </div>

                            <h3
                                class="text-base font-black text-slate-100 uppercase tracking-wide mt-2.5 flex items-center gap-2">
                                <span>{{ $workout->title }}</span>
                                <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                    :class="activeWorkout === {{ $workout->id }} ? 'rotate-180' : ''">▼</span>
                            </h3>

                            <span class="text-xs text-slate-400 block mt-1.5">
                                @if ($workout->last_performed_at)
                                    Выполнялась: {{ $workout->last_performed_at->diffForHumans() }}
                                @else
                                    Еще ни разу не выполнялась
                                @endif
                            </span>
                        </div>

                        <!-- Кнопка удаления -->
                        <form method="POST" action="{{ route('workouts.destroy', $workout->id) }}"
                            onsubmit="return confirm('Удалить эту программу тренировок?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-xl bg-slate-950 border border-slate-900 text-slate-400 hover:text-red-400 hover:border-red-900/30 flex items-center justify-center transition-colors cursor-pointer">
                                <span class="text-xs">✕</span>
                            </button>
                        </form>
                    </div>

                    <!-- Раскрывающийся список упражнений (Alpine) -->
                    <div x-show="activeWorkout === {{ $workout->id }}" x-collapse
                        class="mt-4 pt-4 border-t border-slate-950 space-y-3">
                        <span
                            class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Упражнения:</span>

                        @foreach ($workout->exercises as $exercise)
                            <div class="bg-slate-950/80 border border-slate-900 rounded-xl p-4">
                                <div class="flex justify-between items-center flex-wrap gap-2">
                                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-wide">
                                        {{ $exercise->title }}</h4>
                                    <span
                                        class="text-xs font-mono text-emerald-400 font-bold bg-emerald-500/5 px-2.5 py-1 rounded">
                                        {{ $exercise->sets }} × {{ $exercise->reps }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @if ($exercise->target_muscles)
                                        <span class="text-xs font-bold text-slate-300 bg-slate-900 px-2 py-0.5 rounded">
                                            🎯 {{ $exercise->target_muscles }}
                                        </span>
                                    @endif
                                    @if ($exercise->weight)
                                        <span
                                            class="text-xs font-bold text-amber-400 bg-amber-500/5 px-2 py-0.5 rounded border border-amber-500/10">
                                            💪 {{ $exercise->weight }}
                                        </span>
                                    @endif

                                    <!-- Бейдж прогрессии -->
                                    @if ($exercise->progression_status !== 'new')
                                        <span class="text-xs font-bold px-2 py-0.5 rounded border {{ $exercise->progression_color }}">
                                            📈 {{ $exercise->progression_label }}
                                        </span>
                                    @endif

                                    <!-- Рекомендация при стагнации -->
                                    @if ($exercise->suggested_weight)
                                        <span class="text-xs font-bold text-amber-300 bg-amber-500/5 px-2 py-0.5 rounded border border-amber-400/20">
                                            ⚡ +2.5 кг → {{ $exercise->suggested_weight }} кг
                                        </span>
                                    @endif
                                </div>

                                @if ($exercise->description)
                                    <p
                                        class="text-xs text-slate-300 mt-3 leading-relaxed bg-slate-950 p-3 rounded-lg border border-slate-850/80 font-sans whitespace-pre-line">
                                        {{ $exercise->description }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12 px-6 bg-slate-900/20 rounded-2xl border border-slate-900/50 space-y-4">
                    <span class="text-3xl block">📅</span>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Программы не созданы</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Создайте вашу первую тренировку с помощью кнопки сверху или мгновенно загрузите готовую профессиональную программу!
                    </p>
                    <div class="pt-2">
                        <form method="POST" action="{{ route('workouts.seed_default') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer shadow-lg shadow-emerald-950/40 hover:-translate-y-0.5">
                                🚀 Загрузить PUSH / PULL / LEGS по умолчанию
                            </button>
                        </form>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- ================= БЛОК: БАЗА ЗНАНИЙ ================= -->
        <div class="space-y-3.5 pt-4">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">📖 База знаний</h2>

            <div x-data="{ activeTab: null }" class="grid grid-cols-1 gap-3.5">

                <!-- 1. ПРОГРЕССИЯ -->
                <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-5 shadow-lg">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 1 ? null : 1">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">📈</span>
                            <div>
                                <h3 class="text-sm font-black text-slate-100 uppercase tracking-wide">Прогрессия нагрузок
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5">Еженедельная перегрузка, научный темп и нейросвязь
                                </p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 1 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 1" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🔄 Еженедельная
                                    перегрузка</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Каждую неделю делай ОДНО из:</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Увеличение повторений (например, с 3×10 до 3×11)</li>
                                    <li>Добавление подхода (с 3×10 до 4×10)</li>
                                    <li>Увеличение рабочего веса (например, рюкзак с 3 кг до 5 кг)</li>
                                    <li>Усложнение упражнения (отжимания от пола → ноги на возвышении)</li>
                                    <li>Замедление темпа движения (3 сек вниз, 1 сек вверх)</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🔬 Научный Темп
                                    (3-1-1)</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Контроль негативной фазы (Время под
                                    нагрузкой - Time Under Tension):</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li><strong>3 секунды</strong> — максимально подконтрольно опускай вес</li>
                                    <li><strong>1 секунда</strong> — пауза в нижней точке (растяжение)</li>
                                    <li><strong>1 секунда</strong> — взрывное, мощное позитивное усилие вверх</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🧠
                                    Нейромышечная связь</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Фокус внимания кратно меняет
                                    активацию целевых мышечных волокон:</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li><strong>PUSH:</strong> Думай: "Отталкивай пол/снаряд от себя"</li>
                                    <li><strong>PULL:</strong> Думай: "Тяни локтями назад, а не ладонями"</li>
                                    <li><strong>LEGS:</strong> Думай: "Вдавливай пятки в пол при подъёме"</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">📋 Правило
                                    двойной прогрессии</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Используй оптимальный силовой
                                    диапазон 8–12 повторений:</p>
                                <ul class="list-decimal pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Начни с нижней границы (выполни 8 повторений)</li>
                                    <li>Каждую тренировку добавляй по 1–2 повторения</li>
                                    <li>Когда сможешь сделать 12 раз во всех подходах → УВЕЛИЧЬ ВЕС</li>
                                    <li>Снова начни новый цикл с 8 повторений</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-red-400 uppercase tracking-wider mb-1.5">🛑 Разгрузочная
                                    неделя (Deload)</h4>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Каждые 8–10 недель устраивай разгрузку: делай те же упражнения, но с 50% от обычных
                                    подходов и повторений. При высоком темпе PPL×2 (6 тренировок в неделю) deload жизненно
                                    необходим, чтобы избежать перетренированности ЦНС и воспаления суставов.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. ВОССТАНОВЛЕНИЕ -->
                <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-5 shadow-lg">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 2 ? null : 2">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🧠</span>
                            <div>
                                <h3 class="text-sm font-black text-slate-100 uppercase tracking-wide">Восстановление и сон
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5">Тестостерон, гигиена сна и научные добавки</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 2 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 2" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">😴 Сон — 7–9
                                    часов</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Недосып (меньше 6 часов) снижает
                                    уровень тестостерона на 10–15% всего за одну неделю!</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Ложись и вставай в одно и то же время (±30 мин)</li>
                                    <li>Убирай гаджеты и экраны за 30–60 минут до сна</li>
                                    <li>Спи в полной темноте и прохладе (18–20°C)</li>
                                    <li>Исключи энергетики и кофеин во второй половине дня</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🧘 Управление
                                    стрессом</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Кортизол (гормон стресса) — главный
                                    враг тестостерона и роста мышц:</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Дыхание 4-7-8: вдох 4 сек → задержка 7 сек → выдох 8 сек (3–4 цикла)</li>
                                    <li>Спокойная прогулка на свежем воздухе 15–20 мин перед сном</li>
                                    <li>Принимай прохладный душ 30–60 сек (повышает норэпинефрин на 200-300%)</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🔥
                                    Максимизация Тестостерона</h4>
                                <div class="grid grid-cols-2 gap-3.5 mt-2">
                                    <div>
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">⬆️
                                            СТИМУЛИРУЕТ</span>
                                        <ul class="text-[11px] text-slate-400 space-y-0.5 list-none">
                                            <li>✅ Тяжелые силовые тренировки</li>
                                            <li>✅ Здоровый сон (7–9 ч)</li>
                                            <li>✅ Цинк и магний в еде</li>
                                            <li>✅ Солнечный свет / Витамин D</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <span
                                            class="text-[10px] font-black text-red-400 uppercase tracking-wider block mb-1">⬇️
                                            РАЗРУШАЕТ</span>
                                        <ul class="text-[11px] text-slate-400 space-y-0.5 list-none">
                                            <li>❌ Систематический недосып</li>
                                            <li>❌ Хронический стресс и тревога</li>
                                            <li>❌ Алкоголь (минус 6-10% сразу)</li>
                                            <li>❌ Лишний вес и жир в организме</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">💊 Научно
                                    обоснованные добавки</h4>
                                <ul class="text-xs text-slate-405 space-y-2">
                                    <li>
                                        <strong class="text-amber-400">⭐ Креатин моногидрат (5 г/день)</strong> — дает
                                        +5–10% к силе и выносливости. Самая изученная и эффективная добавка.
                                    </li>
                                    <li>
                                        <strong class="text-indigo-300">⭐ Витамин D3 (2000 МЕ/день)</strong> — критически
                                        важен для синтеза тестостерона, особенно осенью и зимой.
                                    </li>
                                    <li>
                                        <strong class="text-indigo-300">⭐ Магний (200–400 мг)</strong> — принимай перед
                                        сном. Заметно улучшает качество сна и ускоряет расслабление мышц.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. ПИТАНИЕ -->
                <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-5 shadow-lg">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 3 ? null : 3">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🍗</span>
                            <div>
                                <h3 class="text-sm font-black text-slate-100 uppercase tracking-wide">Правила питания</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Правило тарелки, нормы белка и черный список</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 3 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 3" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-red-400 uppercase tracking-wider mb-2">🎯 3 главных
                                    запрета (для сушки и рекомпозиции)</h4>
                                <ul class="list-disc pl-4 text-xs text-slate-450 space-y-1.5">
                                    <li><strong class="text-slate-200">НОЛЬ алкоголя</strong> — полностью блокирует
                                        окисление и сжигание жиров на 24–72 часа + катастрофически рушит тестостерон.</li>
                                    <li><strong class="text-slate-200">НОЛЬ чистого сахара и сладостей</strong> — вызывают
                                        резкий инсулиновый скачок, направляющий калории напрямую в жировые депо.</li>
                                    <li><strong class="text-slate-200">НОЛЬ соков и газировок</strong> — пустые жидкие
                                        калории с огромным объемом сахара, которые не дают насыщения, но моментально
                                        усваиваются.</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🥩 Правило
                                    тарелки (без нудного подсчета КБЖУ)</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Каждый твой основной прием пищи
                                    должен визуально строиться так:</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li><strong>½ тарелки — БЕЛОК</strong> (куриное филе, говядина, индейка, белая/красная
                                        рыба, яйца, творог)</li>
                                    <li><strong>¼ тарелки — СВЕЖИЕ ОВОЩИ</strong> (огурцы, помидоры, зелень, брокколи,
                                        капуста в любом объеме)</li>
                                    <li><strong>¼ тарелки — СЛОЖНЫЕ УГЛЕВОДЫ</strong> (гречка, бурый рис, овсянка длительной
                                        варки, печеный картофель)</li>
                                    <li><strong>+ Полезные жиры</strong> (нерафинированные масла, горсть орехов, авокадо)
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">💡 Белок —
                                    твой главный щит</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Белок защищает твои мышечные волокна
                                    от разрушения при похудении. Без него тело будет жечь мышцы вместо жира!</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Минимум: съедай порцию белка размером с твою ладонь в каждый прием пищи</li>
                                    <li>Одна ладонь белка — это примерно 30–40 г чистого протеина</li>
                                    <li>Суточная цель: около 1.8–2 г белка на 1 кг веса тела</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                    <h4 class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1.5">✅
                                        ЧТО ЕСТЬ МОЖНО</h4>
                                    <ul class="text-[11px] text-slate-400 space-y-1">
                                        <li>• Курица, индейка, говядина</li>
                                        <li>• Любая рыба и яйца</li>
                                        <li>• Гречка, rice, овсянка</li>
                                        <li>• Творог 5-9%, сыры</li>
                                        <li>• Овощи без ограничений</li>
                                    </ul>
                                </div>
                                <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                    <h4 class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1.5">🚫
                                        ЧЕРНЫЙ СПИСОК</h4>
                                    <ul class="text-[11px] text-slate-400 space-y-1">
                                        <li>• Любой алкоголь</li>
                                        <li>• Выпечка, торты, конфеты</li>
                                        <li>• Чипсы, фастфуд, сухарики</li>
                                        <li>• Пакетированные соки</li>
                                        <li>• Сладкие йогурты и соусы</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. ДНЕВНИК И ПРАВИЛА -->
                <div class="bg-slate-900/60 border border-slate-900 rounded-2xl p-5 shadow-lg">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 4 ? null : 4">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">📓</span>
                            <div>
                                <h3 class="text-sm font-black text-slate-100 uppercase tracking-wide">Дневник и график
                                    сплита</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Расписание сплита, замеры и правила пропусков</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 4 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 4" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">📅 Идеальный
                                    PPL×2 график сплита</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Обеспечивает оптимальную частоту
                                    проработки каждой мышечной группы (2 раза в неделю) для стабильного гипертрофического
                                    отклика:</p>
                                <ul class="list-none text-xs text-slate-400 space-y-1.5">
                                    <li><span class="text-indigo-400 font-bold">ПН:</span> 🔴 PUSH (Грудь/Плечи/Трицепс) +
                                        30 мин легкого Zone 2 кардио</li>
                                    <li><span class="text-indigo-400 font-bold">ВТ:</span> 🔴 PULL (Спина/Бицепс)</li>
                                    <li><span class="text-indigo-400 font-bold">СР:</span> 🔴 LEGS + CORE (Ноги/Пресс)</li>
                                    <li><span class="text-indigo-400 font-bold">ЧТ:</span> 🔴 PUSH (Грудь/Плечи/Трицепс) +
                                        30 мин легкого Zone 2 кардио</li>
                                    <li><span class="text-indigo-400 font-bold">ПТ:</span> 🔴 PULL (Спина/Бицепс)</li>
                                    <li><span class="text-indigo-400 font-bold">СБ:</span> 🔴 LEGS + CORE (Ноги/Пресс)</li>
                                    <li><span class="text-emerald-400 font-bold">ВС:</span> ✨ ПОЛНЫЙ ОТДЫХ (или 45 минут
                                        прогулки на свежем воздухе)</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-amber-400 uppercase tracking-wider mb-2">⚠️ Правила
                                    гибкости при пропусках</h4>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Силовую тренировку ВСЕГДА выполняй перед кардио, а не после.</li>
                                    <li><strong>Если пропустил день:</strong> Ничего страшного! Не пытайся сделать две
                                        тренировки в один день. Просто сделай ту тренировку, которая запланирована на
                                        СЕГОДНЯ, пропустив вчерашнюю.</li>
                                    <li>Но помни: пропуская вчерашний день, ты пропускаешь одну группу мышц. Если пропустишь
                                        её два раза подряд — она получит статус <span
                                            class="text-red-400 font-bold">Отстает!</span> и начнет слабеть. Держи баланс!
                                    </li>
                                    <li>Постарайся никогда не допускать пропусков тренировок 2 дня подряд.</li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">📸 Чекпоинты
                                    (Замеры и Фото)</h4>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1.5">
                                    <li><strong>Каждое воскресенье (утро):</strong> Контрольное взвешивание натощак.
                                        Записывай среднее значение за неделю.</li>
                                    <li><strong>Каждое 1-е число месяца:</strong> Полные замеры сантиметровой лентой (талия,
                                        грудь, бицепс, бедро). Максимумы в подтягиваниях и брусьях.</li>
                                    <li><strong>ГЛАВНОЕ: ДЕЛАЙ ФОТО!</strong> Весы часто обманывают из-за задержки воды и
                                        рекомпозиции (когда уходит жир и приходят мышцы). Фотография в зеркале раз в месяц —
                                        твой самый мощный и честный мотиватор!</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= МОДАЛЬНОЕ ОКНО СОЗДАНИЯ С ДИНАМИЧЕСКИМ ФОРМИРОВАНИЕМ НА ALPINE ================= -->
        <x-modal name="create-workout" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6" x-data="{
                exercises: [
                    { title: '', sets: 3, reps: '10-12', target_muscles: '', weight: '', description: '' }
                ],
                addExercise() {
                    this.exercises.push({ title: '', sets: 3, reps: '10-12', target_muscles: '', weight: '', description: '' });
                },
                removeExercise(index) {
                    if (this.exercises.length > 1) {
                        this.exercises.splice(index, 1);
                    }
                }
            }">

                <h2
                    class="text-base font-bold text-slate-100 uppercase tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                    Создать программу
                </h2>

                <form method="POST" action="{{ route('workouts.store') }}" class="space-y-4">
                    @csrf

                    <!-- Название тренировки -->
                    <div>
                        <label for="workout_title"
                            class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Название
                            тренировки</label>
                        <input type="text" name="title" id="workout_title" required
                            placeholder="Например: Силовая А, Сплит: Грудь/Спина"
                            class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-colors">
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Выбор нескольких дней недели (Премиальная сетка бейджей) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Дни недели для
                            тренировки</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ([
            'Понедельник' => 'ПН',
            'Вторник' => 'ВТ',
            'Среда' => 'СР',
            'Четверг' => 'ЧТ',
            'Пятница' => 'ПТ',
            'Суббота' => 'СБ',
            'Воскресенье' => 'ВС',
        ] as $fullDay => $shortDay)
                                <label
                                    class="relative flex items-center justify-center p-3 rounded-xl bg-slate-950 border border-slate-850 cursor-pointer transition-all hover:bg-slate-900 select-none text-center">
                                    <input type="checkbox" name="day_of_week[]" value="{{ $fullDay }}"
                                        class="sr-only peer">
                                    <!-- Элегантная неоновая обводка и фон при выделении -->
                                    <div
                                        class="absolute inset-0 rounded-xl border border-transparent peer-checked:border-indigo-500/40 peer-checked:bg-indigo-500/5 transition-all">
                                    </div>
                                    <span
                                        class="relative z-10 text-xs font-black text-slate-400 peer-checked:text-indigo-400 uppercase tracking-widest">{{ $shortDay }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('day_of_week')" class="mt-1" />
                    </div>

                    <!-- Динамический блок упражнений -->
                    <div class="space-y-4 border-t border-slate-850 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">Упражнения в
                                тренировке</span>
                            <button type="button" x-on:click="addExercise()"
                                class="text-xs font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider cursor-pointer">
                                ➕ Добавить упражнение
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                            <template x-for="(exercise, index) in exercises" :key="index">
                                <div class="bg-slate-950/80 border border-slate-850 p-4 rounded-2xl relative space-y-3">

                                    <!-- Кнопка удаления упражнения -->
                                    <button type="button" x-show="exercises.length > 1"
                                        x-on:click="removeExercise(index)"
                                        class="absolute top-2.5 right-2.5 w-6 h-6 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors cursor-pointer text-xs">
                                        ✕
                                    </button>

                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest"
                                        x-text="'Упражнение #' + (index + 1)"></div>

                                    <!-- Название -->
                                    <div>
                                        <input type="text" :name="'exercises[' + index + '][title]'" required
                                            placeholder="Название (например: Жим штанги лежа)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    <!-- Подходы и повторения -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="number" :name="'exercises[' + index + '][sets]'" required
                                                min="1" placeholder="Подходы (например: 4)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][reps]'" required
                                                placeholder="Повторы (например: 12)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                    <!-- Мышцы и Веса -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][target_muscles]'"
                                                placeholder="Мышцы (например: Грудь)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][weight]'"
                                                placeholder="Вес (например: 50 кг)"
                                                class="w-full bg-slate-900 border border-slate-900 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                    <!-- Описание техники -->
                                    <div>
                                        <textarea :name="'exercises[' + index + '][description]'" rows="2" placeholder="Техника выполнения (необязательно)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors font-sans leading-relaxed"></textarea>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Кнопки управления -->
                    <div class="flex justify-end gap-3 pt-2.5 border-t border-slate-850">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs tracking-wider uppercase transition-all cursor-pointer">
                            Сохранить plan
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

    </div>
@endsection

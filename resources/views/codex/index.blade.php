<x-app-layout title='Кодекс'>
    <!-- Контейнер расширен до max-w-2xl для идеальной гармонии с тренировками и квестами -->
    <div class="max-w-2xl mx-auto p-4 space-y-6" x-data="{ activePillar: 'health' }">
        <a href="{{ route('tools') }}"
            class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all w-fit">
            <span>←</span>
            <span>В Инструменты</span>
        </a>

        <x-h1>📜 Кодекс Охотника</x-h1>

        <!-- ================= БЛОК: 5 СТОЛПОВ СЧАСТЬЯ ================= -->
        <x-card class="space-y-4">
            <!-- Сетка 5-ти плиток -->
            <div class="grid grid-cols-5 gap-2 sm:gap-3">

                <!-- Здоровье -->
                <button type="button" @click="activePillar = 'health'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'health'
                        ?
                        'bg-emerald-500/10 border-emerald-500/50 shadow-[0_0_15px_rgba(16,185,129,0.15)] text-emerald-400 scale-[1.03]' :
                        'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🏥</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Здоровье</span>
                </button>

                <!-- Безопасность -->
                <button type="button" @click="activePillar = 'security'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'security'
                        ?
                        'bg-blue-500/10 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.15)] text-blue-400 scale-[1.03]' :
                        'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🛡️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Защита</span>
                </button>

                <!-- Свобода -->
                <button type="button" @click="activePillar = 'freedom'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'freedom'
                        ?
                        'bg-violet-500/10 border-violet-500/50 shadow-[0_0_15px_rgba(139,92,246,0.15)] text-violet-400 scale-[1.03]' :
                        'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🕊️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Свобода</span>
                </button>

                <!-- Близкие -->
                <button type="button" @click="activePillar = 'family'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'family'
                        ?
                        'bg-rose-500/10 border-rose-500/50 shadow-[0_0_15px_rgba(244,63,94,0.15)] text-rose-400 scale-[1.03]' :
                        'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">❤️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Близкие</span>
                </button>

                <!-- Любимое дело -->
                <button type="button" @click="activePillar = 'work'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'work'
                        ?
                        'bg-amber-500/10 border-amber-500/50 shadow-[0_0_15px_rgba(245,158,11,0.15)] text-amber-400 scale-[1.03]' :
                        'bg-slate-950/50 border-slate-900 text-slate-400 hover:border-slate-800 hover:text-slate-300'">
                    <span class="text-lg mb-1">🎯</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Дело</span>
                </button>

            </div>

            <!-- Детализация выбранного Столпа -->
            <div class="mt-4">

                <!-- ================= ЗДОРОВЬЕ ================= -->
                <div x-show="activePillar === 'health'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-950/60 p-4 rounded-xl border border-emerald-500/20 space-y-3"
                    x-data="{ openSub: 'physical' }">
                    <div class="flex items-center gap-2 text-emerald-400">
                        <span class="text-lg">🏥</span>
                        <x-h3 class="text-xs">Здоровье — Фундамент</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-emerald-400 font-semibold">«Здоровье — это твой главный капитал»</span>. Тело,
                        питание, сон. Выражай эмоции без накопления обид, не стесняйся просить помощь и читай каждый
                        день.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Физическое здоровье & Гигиена --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'physical' ? '' : 'physical'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'physical' ? 'bg-emerald-500/10 text-emerald-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>💪 Физическое Здоровье & Гигиена</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'physical' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'physical'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5">
                                        <strong>🏃‍♂️ Физическая активность:</strong> Регулярные тренировки и кардио для
                                        тонуса тела.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🚭
                                            Без вредных привычек:</strong> Отказ от разрушающих тело веществ.</div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5 sm:col-span-2">
                                        <strong>🩺 Профилактика:</strong> Регулярная профилактика и медицинские осмотры
                                        лучше, быстрее и дешевле лечения.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🚿
                                            Гигиена:</strong> Душ каждый день, дезодорант — обязательно. Чистые ногти,
                                        зубы 2 раза в день, уход за кожей.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5">
                                        <strong>💇‍♂️ Уход за собой:</strong> Стрижка каждые 3–4 недели. Аккуратный
                                        внешний вид.</div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5 sm:col-span-2">
                                        <strong>🧍‍♂️ Осанка & Позвоночник:</strong> Плечи назад, грудь вперёд,
                                        подбородок параллельно полу. Стой у стены 2 мин/день (затылок, лопатки, ягодицы,
                                        пятки).</div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Правила Питания & Диеты --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'nutrition' ? '' : 'nutrition'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'nutrition' ? 'bg-emerald-500/10 text-emerald-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🥗 Правила Питания & Диеты</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'nutrition' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'nutrition'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 space-y-3 text-[11px] font-sans text-slate-300">


                                    <div class="bg-slate-900/50 p-3 rounded-lg border border-emerald-500/10">
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">🥩
                                            Правило Тарелки (без подсчета КБЖУ)</span>
                                        <ul class="list-disc pl-4 space-y-1 text-slate-400">
                                            <li><strong>½ тарелки — БЕЛОК</strong> (куриное филе, говядина, индейка,
                                                белая/красная рыба, яйца, творог)</li>
                                            <li><strong>¼ тарелки — СВЕЖИЕ ОВОЩИ</strong> (огурцы, помидоры, зелень,
                                                брокколи, капуста в любом объеме)</li>
                                            <li><strong>¼ тарелки — СЛОЖНЫЕ УГЛЕВОДЫ</strong> (гречка, бурый рис,
                                                овсянка длительной варки, печеный картофель)</li>
                                            <li><strong>+ Полезные жиры</strong> (нерафинированные масла, горсть орехов,
                                                авокадо)</li>
                                        </ul>
                                    </div>

                                    <div class="bg-slate-900/50 p-3 rounded-lg border border-emerald-500/10">
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">💡
                                            Белок — Твой Главный Щит</span>
                                        <p class="text-slate-400">Белок защищает твои мышечные волокна от разрушения при
                                            похудении. Без него тело будет жечь мышцы вместо жира! Суточная цель: около
                                            1.8–2 г белка на 1 кг веса тела (~30–40 г чистого протеина или порция
                                            размером с ладонь в каждый прием пищи).</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5">
                                            <span
                                                class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">✅
                                                ЧТО ЕСТЬ МОЖНО</span>
                                            <span class="text-slate-400">Курица, индейка, говядина, любая рыба и яйца,
                                                гречка, рис, овсянка, творог 5-9%, сыры, овощи без ограничений.</span>
                                        </div>
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-red-500/5">
                                            <span
                                                class="text-[10px] font-black text-red-400 uppercase tracking-wider block mb-1">🚫
                                                ЧЕРНЫЙ СПИСОК</span>
                                            <span class="text-slate-400">Любой алкоголь, выпечка, торты, конфеты, чипсы,
                                                фастфуд, сухарики, пакетированные соки, сладкие йогурты и соусы.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Восстановление, Сон & Гормоны --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'recovery' ? '' : 'recovery'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'recovery' ? 'bg-emerald-500/10 text-emerald-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>😴 Восстановление, Сон & Гормоны</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'recovery' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'recovery'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 space-y-3 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-3 rounded-lg border border-emerald-500/5">
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">💤
                                            Гигиена Сна (7–9 часов)</span>
                                        <p class="text-slate-400 mb-1.5">Недосып (меньше 6 часов) снижает уровень
                                            тестостерона</p>
                                        <ul class="list-disc pl-4 space-y-0.5 text-slate-400">
                                            <li>Ложись и вставай в одно и то же время (±30 мин).</li>
                                            <li>Убирай гаджеты и экраны за 30–60 минут до сна.</li>
                                            <li>Спи в полной темноте и прохладе (18–20°C).</li>
                                            <li>Исключи энергетики и кофеин во второй половине дня.</li>
                                        </ul>
                                    </div>

                                    <div class="bg-slate-900/50 p-3 rounded-lg border border-emerald-500/5">
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">🧘
                                            Управление Стрессом & Кортизол</span>
                                        <p class="text-slate-400 mb-1.5">Кортизол (гормон стресса) — главный враг
                                            тестостерона и роста мышц:</p>
                                        <ul class="list-disc pl-4 space-y-0.5 text-slate-400">
                                            <li>Дыхание 4-7-8: вдох 4 сек → задержка 7 сек → выдох 8 сек (3–4 цикла).
                                            </li>
                                            <li>Спокойная прогулка на свежем воздухе 15–20 мин перед сном.</li>
                                            <li>Принимай прохладный душ 30–60 сек.</li>
                                        </ul>
                                    </div>



                                    <div class="bg-slate-900/50 p-3 rounded-lg border border-emerald-500/5">
                                        <span
                                            class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block mb-1">💊
                                            Научно обоснованные добавки</span>
                                        <ul class="space-y-1.5 text-slate-400">
                                            <li><strong class="text-amber-400">⭐ Креатин моногидрат (5 г/день)</strong>
                                                — дает +5–10% к силе и выносливости. Самая изученная и эффективная
                                                добавка.</li>
                                            <li><strong class="text-emerald-300">⭐ Витамин D3 (2000 МЕ/день)</strong> —
                                                критически важен для синтеза тестостерона, особенно осенью и зимой.</li>
                                            <li><strong class="text-emerald-300">⭐ Магний (200–400 мг)</strong> —
                                                принимай перед сном. Заметно улучшает качество сна и ускоряет
                                                расслабление мышц.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= ЗАЩИТА ================= -->
                <div x-show="activePillar === 'security'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-950/60 p-4 rounded-xl border border-blue-500/20 space-y-3"
                    x-data="{ openSub: 'personal' }">
                    <div class="flex items-center gap-2 text-blue-400">
                        <span class="text-lg">🛡️</span>
                        <x-h3 class="text-xs">Безопасность — Спокойствие Духа</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        Настоящая безопасность — это <span class="text-blue-400 font-semibold">«отсутствие постоянного
                            страха за завтрашний день»</span>. Это финансовая, физическая и юридическая защита, которая
                        избавляет мозг от стресса выживания.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Личная безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'personal' ? '' : 'personal'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'personal' ? 'bg-blue-500/10 text-blue-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>👤 Личная Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'personal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'personal'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🏠
                                            Безопасный район:</strong> Территория влияет на нас больше, чем мы думаем.
                                        Выбирай надежную среду обитания.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🛡️
                                            Предотвращение угроз:</strong> Избегай заведомо опасных ситуаций. Лучшая
                                        битва — та, которая не состоялась.</div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2">
                                        <strong>🥋 Умение постоять за себя:</strong> Знания самообороны подобны
                                        страховке: лучше иметь и не нуждаться, чем нуждаться и не иметь.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Экономическая безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'economic' ? '' : 'economic'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'economic' ? 'bg-blue-500/10 text-blue-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>💰 Экономическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'economic' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'economic'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>📈
                                            Стабильный доход:</strong> Наличие надежного и легального источника дохода,
                                        приносящего удовлетворение.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>💼
                                            Подушка безопасности:</strong> Финансовый резерв, покрывающий минимум 6
                                        месяцев твоих обычных расходов.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Юридическая безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'legal' ? '' : 'legal'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'legal' ? 'bg-blue-500/10 text-blue-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>⚖️ Юридическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'legal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'legal'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>📜
                                            Знание своих прав:</strong> Понимай свои права, законы и правовые
                                        возможности. Знание законов освобождает от многих проблем.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🔑
                                            Легальные статусы:</strong> Держи в порядке все необходимые доступы,
                                        разрешения, лицензии и документы.</div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2">
                                        <strong>💼 Законное ведение дел:</strong> Защита от злоумышленников через
                                        честный бизнес. Полный отказ от «серых» схем, срезания углов и мутных связей.
                                    </div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2">
                                        <strong>✍️ Письменное оформление:</strong> Абсолютно любые сделки и отношения с
                                        физ. и юр. лицами фиксируй строго в письменном виде по закону.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= СВОБОДА ================= -->
                <div x-show="activePillar === 'freedom'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-950/60 p-4 rounded-xl border border-violet-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-violet-400">
                        <span class="text-lg">🕊️</span>
                        <x-h3 class="text-xs">Свобода — Думай Своей Головой</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-violet-400 font-semibold">«Свобода — это возможность не делать то, чего ты
                            делать не хочешь»</span>. Свобода от чужих ожиданий, долгов и навязанного мнения.
                    </x-p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🧠 Критическое
                                мышление:</strong> Никогда не верь слепо. Спрашивай: «Где доказательства? Кому выгодно?»
                        </div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🛡️ Стойкость
                                к давлению:</strong> Четкие внутренние ориентиры помогают противостоять манипуляциям и давлению общества.
                        </div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>⚖️
                                Ценностный выбор:</strong> Принимая решение, спрашивай себя: «Какой вариант соответствует моим ценностям?» Это дает ясность и целостность.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🧘‍♂️
                                Самодостаточность:</strong> Умей быть счастливым наедине с собой. Решай проблемы сам.
                        </div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5 sm:col-span-2"><strong>🙏
                                Благодарность:</strong> Счастливый человек радуется тому, что у него есть, а не страдает по тому, чего нет. Регулярно фиксируй ценность имеющегося.
                        </div>
                    </div>
                </div>

                <!-- ================= БЛИЗКИЕ ================= -->
                <div x-show="activePillar === 'family'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-950/60 p-4 rounded-xl border border-rose-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-rose-400">
                        <span class="text-lg">❤️</span>
                        <x-h3 class="text-xs">Близкие — Окружение и Речь</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-rose-400 font-semibold">«Отношения — это сад, его нужно поливать каждый
                            день»</span>. Избавляйся от токсичных связей, окружай себя донаторами энергии.
                    </x-p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>👁️ Зрительный
                                контакт:</strong> Смотри в глаза при разговоре — мягко и уверенно.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>⏰
                                Пунктуальность:</strong> Приходи на 5 мин раньше.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>🗣️ Темп
                                речи:</strong> Говори медленнее — быстрая речь = нервозность.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>🚫 Без
                                слов-паразитов:</strong> Убери «ну», «типа», «короче», «как бы».</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>👔
                                Уверенность:</strong> Не оправдывайся без реальной причины.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>🤲
                                Альтруизм:</strong> Помогай без ожидания ответной выгоды.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5"><strong>❤️
                                Знаки внимания:</strong> Проявляй маленькие знаки внимания близким — они создают большую любовь.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5 sm:col-span-2"><strong>👨‍👩‍👦
                                Время для семьи:</strong> Регулярно уделяй время живому общению с членами семьи.</div>
                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-rose-500/5 sm:col-span-2"><strong>🔇
                                Уважение:</strong> Не перебивай. Не жалуйся. Читай вслух для тренировки дикции.</div>
                    </div>
                </div>

                <!-- ================= ДЕЛО ================= -->
                <div x-show="activePillar === 'work'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-950/60 p-4 rounded-xl border border-amber-500/20 space-y-3"
                    x-data="{ openSub: 'discipline' }">
                    <div class="flex items-center gap-2 text-amber-400">
                        <span class="text-lg">🎯</span>
                        <x-h3 class="text-xs">Дело — Kaizen & Дисциплина</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-amber-400 font-semibold">«+1% каждый день»</span>. Маленькие шаги в ремесле
                        ведут к величию. Фокус на пользе людям и качестве процесса.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'discipline' ? '' : 'discipline'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'discipline' ? 'bg-amber-500/10 text-amber-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>⚔️ Дисциплина & Сила Воли</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'discipline' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'discipline'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 space-y-3 text-[11px] font-sans text-slate-300">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5">
                                            <strong>🛡️ Честность:</strong> Признавай свои ошибки быстро и без
                                            оправданий.</div>
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5">
                                            <strong>🤐 Принятие:</strong> Не жалуйся — либо решай проблему, либо смирись
                                            и прими её.</div>
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5">
                                            <strong>🧘‍♂️ Контроль:</strong> Контролируй реакции — ты не владеешь
                                            внешним миром, но владеешь собой.</div>
                                        <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5">
                                            <strong>🎯 Целеполагание:</strong> Действуй целенаправленно. Есть цель — есть движение, нет цели — нет движения.</div>
                                        <div
                                            class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5 sm:col-span-2">
                                            <strong>🧠 Лидерство:</strong> Будь спокоен под давлением — это отличает
                                            лидера от толпы.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Быт & Порядок в Доме --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'household' ? '' : 'household'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'household' ? 'bg-amber-500/10 text-amber-400' :
                                    'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🏠 Быт & Порядок в Доме</span>
                                <span class="text-[9px] transition-transform duration-200"
                                    :class="openSub === 'household' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'household'" x-collapse>
                                <div
                                    class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5"><strong>🛌
                                            Утро:</strong> Заправил кровать каждое утро (30 сек → задаёт тон дня).</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5"><strong>🍽️
                                            Чистота:</strong> Не копи грязную посуду. Мой сразу.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5"><strong>🌬️
                                            Свежесть:</strong> Регулярно проветривай комнату. Приятный запах дома
                                        повышает тонус.</div>
                                    <div
                                        class="bg-slate-900/50 p-2.5 rounded-lg border border-amber-500/5 sm:col-span-2">
                                        <strong>🍳 Кулинария:</strong> Умей готовить минимум 5 базовых блюд: яичница,
                                        паста, рис+мясо, салат, суп.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

    </div>
</x-app-layout>

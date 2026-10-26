<x-app-layout title='Кодекс'>
    <!-- Контейнер расширен до max-w-2xl для идеальной гармонии с тренировками и квестами -->
    <div class="max-w-2xl mx-auto p-4 space-y-6" x-data="{ activePillar: 'health' }">
        <a href="{{ route('tools') }}"
            class="text-[10px] font-extrabold text-indigo-700 hover:text-indigo-800 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-white px-3.5 py-2 rounded-xl border border-slate-200 hover:border-indigo-400 hover:-translate-y-0.5 transition-all w-fit shadow-sm">
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
                        'bg-emerald-50 border-emerald-300 shadow-[0_2px_12px_rgba(16,185,129,0.15)] text-emerald-800 font-extrabold scale-[1.03]' :
                        'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-900'">
                    <span class="text-lg mb-1">🏥</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Здоровье</span>
                </button>

                <!-- Безопасность -->
                <button type="button" @click="activePillar = 'security'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'security'
                        ?
                        'bg-blue-50 border-blue-300 shadow-[0_2px_12px_rgba(59,130,246,0.15)] text-blue-800 font-extrabold scale-[1.03]' :
                        'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-900'">
                    <span class="text-lg mb-1">🛡️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Защита</span>
                </button>

                <!-- Свобода -->
                <button type="button" @click="activePillar = 'freedom'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'freedom'
                        ?
                        'bg-violet-50 border-violet-300 shadow-[0_2px_12px_rgba(139,92,246,0.15)] text-violet-800 font-extrabold scale-[1.03]' :
                        'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-900'">
                    <span class="text-lg mb-1">🕊️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Свобода</span>
                </button>

                <!-- Близкие -->
                <button type="button" @click="activePillar = 'family'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'family'
                        ?
                        'bg-rose-50 border-rose-300 shadow-[0_2px_12px_rgba(244,63,94,0.15)] text-rose-800 font-extrabold scale-[1.03]' :
                        'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-900'">
                    <span class="text-lg mb-1">❤️</span>
                    <span class="text-[9px] font-extrabold uppercase tracking-wide">Близкие</span>
                </button>

                <!-- Любимое дело -->
                <button type="button" @click="activePillar = 'work'"
                    class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 cursor-pointer focus:outline-none"
                    :class="activePillar === 'work'
                        ?
                        'bg-amber-50 border-amber-300 shadow-[0_2px_12px_rgba(245,158,11,0.15)] text-amber-800 font-extrabold scale-[1.03]' :
                        'bg-slate-50 border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-900'">
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
                    class="bg-emerald-50/40 p-4 rounded-2xl border border-emerald-200/80 space-y-3.5"
                    x-data="{ openSub: 'physical' }">
                    <div class="flex items-center gap-2 text-emerald-800">
                        <span class="text-lg">🏥</span>
                        <x-h3 class="text-xs text-emerald-900 font-black">Здоровье — Фундамент</x-h3>
                    </div>
                    <x-p class="text-slate-700">
                        <span class="text-emerald-800 font-bold">«Здоровье — это твой главный капитал»</span>. Тело,
                        питание, сон. Выражай эмоции без накопления обид, не стесняйся просить помощь и читай каждый
                        день.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Физическое здоровье & Гигиена --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'physical' ? '' : 'physical'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'physical' ? 'bg-emerald-50 text-emerald-800 border-b border-emerald-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>💪 Физическое Здоровье & Гигиена</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'physical' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'physical'" x-collapse>
                                <div
                                    class="p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80">
                                        <strong class="text-slate-900">🏃‍♂️ Физическая активность:</strong> Регулярные тренировки и кардио для тонуса тела.
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80">
                                        <strong class="text-slate-900">🚭 Без вредных привычек:</strong> Отказ от разрушающих тело веществ.
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2">
                                        <strong class="text-slate-900">🩺 Профилактика:</strong> Регулярная профилактика и медицинские осмотры лучше, быстрее и дешевле лечения.
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2">
                                        <strong class="text-slate-900">🧍‍♂️ Осанка & Позвоночник:</strong> Плечи назад, грудь вперёд, подбородок параллельно полу. Стой у стены 2 мин/день (затылок, лопатки, ягодицы, пятки).
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Правила Питания & Диеты --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'nutrition' ? '' : 'nutrition'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'nutrition' ? 'bg-emerald-50 text-emerald-800 border-b border-emerald-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>🥗 Правила Питания & Диеты</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'nutrition' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'nutrition'" x-collapse>
                                <div class="p-3 bg-white space-y-3 text-[11px] font-sans text-slate-700">

                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">🥩
                                            Правило Тарелки (без подсчета КБЖУ)</span>
                                        <ul class="list-disc pl-4 space-y-1 text-slate-700">
                                            <li><strong class="text-slate-900">½ тарелки — БЕЛОК</strong> (куриное филе, говядина, индейка, белая/красная рыба, яйца, творог)</li>
                                            <li><strong class="text-slate-900">¼ тарелки — СВЕЖИЕ ОВОЩИ</strong> (огурцы, помидоры, зелень, брокколи, капуста в любом объеме)</li>
                                            <li><strong class="text-slate-900">¼ тарелки — СЛОЖНЫЕ УГЛЕВОДЫ</strong> (гречка, бурый рис, овсянка длительной варки, печеный картофель)</li>
                                            <li><strong class="text-slate-900">+ Полезные жиры</strong> (нерафинированные масла, горсть орехов, авокадо)</li>
                                        </ul>
                                    </div>

                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">💡
                                            Белок — Твой Главный Щит</span>
                                        <p class="text-slate-700">Белок защищает твои мышечные волокна от разрушения при похудении. Без него тело будет жечь мышцы вместо жира! Суточная цель: около 1.8–2 г белка на 1 кг веса тела (~30–40 г чистого протеина или порция размером с ладонь в каждый прием пищи).</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div class="bg-emerald-50/70 p-2.5 rounded-lg border border-emerald-200">
                                            <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">✅ ЧТО ЕСТЬ МОЖНО</span>
                                            <span class="text-slate-700">Курица, индейка, говядина, любая рыба и яйца, гречка, рис, овсянка, творог 5-9%, сыры, овощи без ограничений.</span>
                                        </div>
                                        <div class="bg-rose-50/70 p-2.5 rounded-lg border border-rose-200">
                                            <span class="text-[10px] font-black text-rose-800 uppercase tracking-wider block mb-1">🚫 ЧЕРНЫЙ СПИСОК</span>
                                            <span class="text-slate-700">Любой алкоголь, выпечка, торты, конфеты, чипсы, фастфуд, сухарики, пакетированные соки, сладкие йогурты и соусы.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Восстановление, Сон & Гормоны --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'recovery' ? '' : 'recovery'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'recovery' ? 'bg-emerald-50 text-emerald-800 border-b border-emerald-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>😴 Восстановление, Сон & Гормоны</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'recovery' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'recovery'" x-collapse>
                                <div class="p-3 bg-white space-y-3 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">💤
                                            Гигиена Сна (7–9 часов)</span>
                                        <p class="text-slate-700 mb-1.5 font-medium">Недосып (меньше 6 часов) снижает уровень тестостерона</p>
                                        <ul class="list-disc pl-4 space-y-0.5 text-slate-700">
                                            <li>Ложись и вставай в одно и то же время (±30 мин).</li>
                                            <li>Убирай гаджеты и экраны за 30–60 минут до сна.</li>
                                            <li>Спи в полной темноте и прохладе (18–20°C).</li>
                                            <li>Исключи энергетики и кофеин во второй половине дня.</li>
                                        </ul>
                                    </div>

                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">🧘
                                            Управление Стрессом & Кортизол</span>
                                        <p class="text-slate-700 mb-1.5 font-medium">Кортизол (гормон стресса) — главный враг тестостерона и роста мышц:</p>
                                        <ul class="list-disc pl-4 space-y-0.5 text-slate-700">
                                            <li>Дыхание 4-7-8: вдох 4 сек → задержка 7 сек → выдох 8 сек (3–4 цикла).</li>
                                            <li>Спокойная прогулка на свежем воздухе 15–20 мин перед сном.</li>
                                            <li>Принимай прохладный душ 30–60 сек.</li>
                                        </ul>
                                    </div>

                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block mb-1">💊
                                            Научно обоснованные добавки</span>
                                        <ul class="space-y-1.5 text-slate-700">
                                            <li><strong class="text-amber-800">⭐ Креатин моногидрат (5 г/день)</strong> — дает +5–10% к силе и выносливости. Самая изученная и эффективная добавка.</li>
                                            <li><strong class="text-emerald-800">⭐ Витамин D3 (2000 МЕ/день)</strong> — критически важен для синтеза тестостерона, особенно осенью и зимой.</li>
                                            <li><strong class="text-indigo-800">⭐ Магний (200–400 мг)</strong> — принимай перед сном. Заметно улучшает качество сна и ускоряет расслабление мышц.</li>
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
                    class="bg-blue-50/40 p-4 rounded-2xl border border-blue-200/80 space-y-3.5"
                    x-data="{ openSub: 'personal' }">
                    <div class="flex items-center gap-2 text-blue-800">
                        <span class="text-lg">🛡️</span>
                        <x-h3 class="text-xs text-blue-900 font-extrabold">Безопасность — Спокойствие Духа</x-h3>
                    </div>
                    <x-p class="text-slate-700">
                        Настоящая безопасность — это <span class="text-blue-800 font-bold">«отсутствие постоянного страха за завтрашний день»</span>. Это финансовая, физическая и юридическая защита, которая избавляет мозг от стресса выживания.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Личная безопасность --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'personal' ? '' : 'personal'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'personal' ? 'bg-blue-50 text-blue-800 border-b border-blue-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>👤 Личная Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'personal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'personal'" x-collapse>
                                <div class="p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🏠 Безопасный район:</strong> Территория влияет на нас больше, чем мы думаем. Выбирай надежную среду обитания.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🛡️ Предотвращение угроз:</strong> Избегай заведомо опасных ситуаций. Лучшая битва — та, которая не состоялась.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2">
                                        <strong class="text-slate-900">🥋 Умение постоять за себя:</strong> Знания самообороны подобны страховке: лучше иметь и не нуждаться, чем нуждаться и не иметь.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Экономическая безопасность --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'economic' ? '' : 'economic'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'economic' ? 'bg-blue-50 text-blue-800 border-b border-blue-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>💰 Экономическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'economic' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'economic'" x-collapse>
                                <div class="p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">📈 Стабильный доход:</strong> Наличие надежного и легального источника дохода, приносящего удовлетворение.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">💼 Подушка безопасности:</strong> Финансовый резерв, покрывающий минимум 6 месяцев твоих обычных расходов.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Юридическая безопасность --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'legal' ? '' : 'legal'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'legal' ? 'bg-blue-50 text-blue-800 border-b border-blue-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>⚖️ Юридическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'legal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'legal'" x-collapse>
                                <div class="p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">📜 Знание своих прав:</strong> Понимай свои права, законы и правовые возможности. Знание законов освобождает от многих проблем.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🔑 Легальные статусы:</strong> Держи в порядке все необходимые доступы, разрешения, лицензии и документы.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2">
                                        <strong class="text-slate-900">💼 Законное ведение дел:</strong> Защита от злоумышленников через честный бизнес. Полный отказ от «серых» схем, срезания углов и мутных связей.
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2">
                                        <strong class="text-slate-900">✍️ Письменное оформление:</strong> Абсолютно любые сделки и отношения с физ. и юр. лицами фиксируй строго в письменном виде по закону.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= СВОБОДА ================= -->
                <div x-show="activePillar === 'freedom'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-violet-50/40 p-4 rounded-2xl border border-violet-200/80 space-y-3.5">
                    <div class="flex items-center gap-2 text-violet-800">
                        <span class="text-lg">🕊️</span>
                        <x-h3 class="text-xs text-violet-900 font-extrabold">Свобода — Думай Своей Головой</x-h3>
                    </div>
                    <x-p class="text-slate-700">
                        <span class="text-violet-800 font-bold">«Свобода — это возможность не делать то, чего ты делать не хочешь»</span>. Свобода от чужих ожиданий, долгов и навязанного мнения.
                    </x-p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🧠 Критическое мышление:</strong> Никогда не верь слепо. Спрашивай: «Где доказательства? Кому выгодно?»</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🛡️ Стойкость к давлению:</strong> Четкие внутренние ориентиры помогают противостоять манипуляциям и давлению общества.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">⚖️ Ценностный выбор:</strong> Принимая решение, спрашивай себя: «Какой вариант соответствует моим ценностям?» Это дает ясность и целостность.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🧘‍♂️ Самодостаточность:</strong> Умей быть счастливым наедине с собой. Решай проблемы сам.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">🙏 Благодарность:</strong> Счастливый человек радуется тому, что у него есть, а не страдает по тому, чего нет. Регулярно фиксируй ценность имеющегося.</div>
                    </div>
                </div>

                <!-- ================= БЛИЗКИЕ ================= -->
                <div x-show="activePillar === 'family'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-rose-50/40 p-4 rounded-2xl border border-rose-200/80 space-y-3.5">
                    <div class="flex items-center gap-2 text-rose-800">
                        <span class="text-lg">❤️</span>
                        <x-h3 class="text-xs text-rose-900 font-extrabold">Близкие — Окружение и Речь</x-h3>
                    </div>
                    <x-p class="text-slate-700">
                        <span class="text-rose-800 font-bold">«Отношения — это сад, его нужно поливать каждый день»</span>. Избавляйся от токсичных связей, окружай себя донаторами энергии.
                    </x-p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">👁️ Зрительный контакт:</strong> Смотри в глаза при разговоре — мягко и уверенно.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">⏰ Пунктуальность:</strong> Приходи на 5 мин раньше.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🗣️ Темп речи:</strong> Говори медленнее — быстрая речь = нервозность.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🚫 Без слов-паразитов:</strong> Убери «ну», «типа», «короче», «как бы».</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">👔 Уверенность:</strong> Не оправдывайся без реальной причины.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">🤲 Альтруизм:</strong> Помогай без ожидания ответной выгоды.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm"><strong class="text-slate-900">❤️ Знаки внимания:</strong> Проявляй маленькие знаки внимания близким — они создают большую любовь.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">👨‍👩‍👦 Время для близких:</strong> Выделяй фиксированное время в расписании для общения с любимыми, чтобы не откладывать его «на потом».</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">⚡ Внимание и забота:</strong> Общайся с искренним интересом к их жизни. Сопереживай, делись энергией и делай всё с любовью.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">🥂 Свидания наедине:</strong> Проводи еженедельное свидание с партнером один на один. Задавай вопросы, чтобы обновлять «карту любви» (его заботы, радости и мечты).</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">🌅 Ритуалы общения:</strong> Утром узнавай о планах близкого человека на день. Вечером проводи разговор для снятия дневного стресса и воссоединения.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">🫂 Тактильность и тепло:</strong> Ежедневно выражай нежность и восхищение. Обнимай, касайся и обязательно целуй перед сном, чтобы сбросить накопившееся раздражение.</div>
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200/80 shadow-sm sm:col-span-2"><strong class="text-slate-900">🔇 Уважение:</strong> Не перебивай. Не жалуйся. Слушай до конца, прежде чем отвечать.</div>
                    </div>
                </div>

                <!-- ================= ДЕЛО ================= -->
                <div x-show="activePillar === 'work'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-amber-50/40 p-4 rounded-2xl border border-amber-200/80 space-y-3.5"
                    x-data="{ openSub: 'discipline' }">
                    <div class="flex items-center gap-2 text-amber-800">
                        <span class="text-lg">🎯</span>
                        <x-h3 class="text-xs text-amber-900 font-extrabold">Дело — Kaizen & Дисциплина</x-h3>
                    </div>
                    <x-p class="text-slate-700">
                        <span class="text-amber-800 font-bold">«+1% каждый день»</span>. Маленькие шаги в ремесле ведут к величию. Фокус на пользе людям и качестве процесса.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'discipline' ? '' : 'discipline'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'discipline' ? 'bg-amber-50 text-amber-800 border-b border-amber-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>⚔️ Дисциплина & Сила Воли</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'discipline' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'discipline'" x-collapse>
                                <div class="p-3 bg-white space-y-3 text-[11px] font-sans text-slate-700">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🛡️ Честность:</strong> Признавай свои ошибки быстро и без оправданий.</div>
                                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🤐 Принятие:</strong> Не жалуйся — либо решай проблему, либо смирись и прими её.</div>
                                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🧘‍♂️ Контроль:</strong> Контролируй реакции — ты не владеешь внешним миром, но владеешь собой.</div>
                                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🎯 Целеполагание:</strong> Действуй целенаправленно. Есть цель — есть движение, нет цели — нет движения.</div>
                                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2"><strong class="text-slate-900">🧠 Лидерство:</strong> Будь спокоен под давлением — это отличает лидера от толпы.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Быт & Порядок в Доме --}}
                        <div class="rounded-xl border border-slate-200/90 overflow-hidden bg-white shadow-sm">
                            <button type="button" @click="openSub = openSub === 'household' ? '' : 'household'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200"
                                :class="openSub === 'household' ? 'bg-amber-50 text-amber-800 border-b border-amber-100' :
                                    'bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900'">
                                <span>🏠 Быт & Порядок в Доме</span>
                                <span class="text-[9px] transition-transform duration-200 text-slate-400"
                                    :class="openSub === 'household' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'household'" x-collapse>
                                <div class="p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-700">
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🛌 Утро:</strong> Заправил кровать каждое утро (30 сек → задаёт тон дня).</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🍽️ Чистота:</strong> Не копи грязную посуду. Мой сразу.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80"><strong class="text-slate-900">🌬️ Свежесть:</strong> Регулярно проветривай комнату. Приятный запах дома повышает тонус.</div>
                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 sm:col-span-2"><strong class="text-slate-900">🍳 Кулинария:</strong> Умей готовить минимум 5 базовых блюд: яичница, паста, рис+мясо, салат, суп.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

    </div>
</x-app-layout>

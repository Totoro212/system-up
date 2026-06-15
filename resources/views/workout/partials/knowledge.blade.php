        <!-- ================= БЛОК: БАЗА ЗНАНИЙ ================= -->
        <div class="space-y-3.5 pt-4">
            <x-h2>📖 База знаний</x-h2>

            <div x-data="{ activeTab: null }" class="grid grid-cols-1 gap-3.5">

                <!-- 1. ПРОГРЕССИЯ -->
                <x-card class="bg-slate-900/60 border-slate-900">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 1 ? null : 1">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">📈</span>
                            <div>
                                <x-h3>Прогрессия нагрузок</x-h3>
                                <x-p class="text-slate-400 mt-0.5">Еженедельная перегрузка, научный темп и нейросвязь</x-p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 1 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 1" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🔄
                                    Еженедельная
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
                                <h4 class="text-xs font-black text-red-400 uppercase tracking-wider mb-1.5">🛑
                                    Разгрузочная
                                    неделя (Deload)</h4>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Каждые 8–10 недель устраивай разгрузку: делай те же упражнения, но с 50% от обычных
                                    подходов и повторений. При высоком темпе PPL×2 (6 тренировок в неделю) deload
                                    жизненно
                                    необходим, чтобы избежать перетренированности ЦНС и воспаления суставов.
                                </p>
                            </div>
                        </div>
                    </div>
                </x-card>

                <!-- 2. ВОССТАНОВЛЕНИЕ -->
                <x-card class="bg-slate-900/60 border-slate-900">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 2 ? null : 2">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🧠</span>
                            <div>
                                <x-h3>Восстановление и сон</x-h3>
                                <x-p class="text-slate-400 mt-0.5">Тестостерон, гигиена сна и научные добавки</x-p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 2 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 2" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">
                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">😴 Сон —
                                    7–9
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
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">🧘
                                    Управление
                                    стрессом</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Кортизол (гормон стресса) —
                                    главный
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
                                        <strong class="text-indigo-300">⭐ Витамин D3 (2000 МЕ/день)</strong> —
                                        критически
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
                </x-card>

                <!-- 3. ПИТАНИЕ -->
                <x-card class="bg-slate-900/60 border-slate-900">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 3 ? null : 3">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🍗</span>
                            <div>
                                <x-h3>Правила питания</x-h3>
                                <x-p class="text-slate-400 mt-0.5">Правило тарелки, нормы белка и черный список</x-p>
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
                                        окисление и сжигание жиров на 24–72 часа + катастрофически рушит тестостерон.
                                    </li>
                                    <li><strong class="text-slate-200">НОЛЬ чистого сахара и сладостей</strong> —
                                        вызывают
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
                                    <li><strong>½ тарелки — БЕЛОК</strong> (куриное филе, говядина, индейка,
                                        белая/красная
                                        рыба, яйца, творог)</li>
                                    <li><strong>¼ тарелки — СВЕЖИЕ ОВОЩИ</strong> (огурцы, помидоры, зелень, брокколи,
                                        капуста в любом объеме)</li>
                                    <li><strong>¼ тарелки — СЛОЖНЫЕ УГЛЕВОДЫ</strong> (гречка, бурый рис, овсянка
                                        длительной
                                        варки, печеный картофель)</li>
                                    <li><strong>+ Полезные жиры</strong> (нерафинированные масла, горсть орехов,
                                        авокадо)
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">💡 Белок —
                                    твой главный щит</h4>
                                <p class="text-xs text-slate-300 leading-relaxed mb-2">Белок защищает твои мышечные
                                    волокна
                                    от разрушения при похудении. Без него тело будет жечь мышцы вместо жира!</p>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Минимум: съедай порцию белка размером с твою ладонь в каждый прием пищи</li>
                                    <li>Одна ладонь белка — это примерно 30–40 г чистого протеина</li>
                                    <li>Суточная цель: около 1.8–2 г белка на 1 кг веса тела</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                    <h4
                                        class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1.5">
                                        ✅
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
                </x-card>

                <!-- 4. ДНЕВНИК И ПРАВИЛА -->
                <x-card class="bg-slate-900/60 border-slate-900">
                    <div class="cursor-pointer flex justify-between items-center"
                        x-on:click="activeTab = activeTab === 4 ? null : 4">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">📓</span>
                            <div>
                                <x-h3>Дневник и график сплита</x-h3>
                                <x-p class="text-slate-400 mt-0.5">Расписание сплита, замеры и правила пропусков</x-p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 transform transition-transform duration-200"
                            :class="activeTab === 4 ? 'rotate-180' : ''">▼</span>
                    </div>

                    <div x-show="activeTab === 4" x-collapse class="mt-4 pt-4 border-t border-slate-950 space-y-4">
                        <div class="space-y-3.5">

                            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-900">
                                <h4 class="text-xs font-black text-amber-400 uppercase tracking-wider mb-2">⚠️ Правила
                                    гибкости при пропусках</h4>
                                <ul class="list-disc pl-4 text-xs text-slate-400 space-y-1">
                                    <li>Силовую тренировку ВСЕГДА выполняй перед кардио, а не после.</li>
                                    <li><strong>Если пропустил день:</strong> Ничего страшного! Не пытайся сделать две
                                        тренировки в один день. Просто сделай ту тренировку, которая запланирована на
                                        СЕГОДНЯ, пропустив вчерашнюю.</li>
                                    <li>Но помни: пропуская вчерашний день, ты пропускаешь одну группу мышц. Если
                                        пропустишь
                                        её два раза подряд — она получит статус <span
                                            class="text-red-400 font-bold">Отстает!</span> и начнет слабеть. Держи
                                        баланс!
                                    </li>
                                    <li>Постарайся никогда не допускать пропусков тренировок 2 дня подряд.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </x-card>

            </div>
        </div>

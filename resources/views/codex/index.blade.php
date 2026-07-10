
<x-app-layout title='Кодекс'>
    <!-- Контейнер расширен до max-w-2xl для идеальной гармонии с тренировками и квестами -->
    <div class="max-w-2xl mx-auto p-4 space-y-6" x-data="{ activeCategory: null }">

        <x-h1>📜 Кодекс Охотника</x-h1>

        <!-- ================= БЛОК: 5 СТОЛПОВ СЧАСТЬЯ ================= -->
        <x-card x-data="{ activePillar: 'health' }" class="space-y-4">
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
                     class="bg-slate-950/60 p-4 rounded-xl border border-emerald-500/20 space-y-3"
                     x-data="{ openSub: 'physical' }">
                    <div class="flex items-center gap-2 text-emerald-400">
                        <span class="text-lg">🏥</span>
                        <x-h3 class="text-xs">Здоровье — Фундамент</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-emerald-400 font-semibold">«Здоровье — это твой главный физический капитал»</span>. Твое тело — это биологический компьютер. Если он зависает или перегревается, никакие успехи в бизнесе или делах не принесут счастья. Спорт, здоровое питание, сон и близкие связи напрямую способствуют выработке гормонов счастья (дофамина, серотонина, эндорфинов и окситоцина).
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Физическое здоровье --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'physical' ? '' : 'physical'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'physical' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>💪 Физическое Здоровье</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'physical' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'physical'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🏃‍♂️ Физическая активность:</strong> Регулярные тренировки дают тонус.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🥗 Здоровое питание:</strong> Мы буквально состоим из того, что едим.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>💤 Достаточный сон:</strong> Время, когда тело и мозг полностью восстанавливаются.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🚭 Без вредных привычек:</strong> Они как ржавчина, незаметно разъедающая внутренний механизм.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5 sm:col-span-2"><strong>🩺 Медицинские осмотры:</strong> Регулярная профилактика всегда лучше, быстрее и дешевле лечения.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Эмоциональное здоровье --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'emotional' ? '' : 'emotional'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'emotional' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🌀 Эмоциональное Здоровье</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'emotional' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'emotional'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>💬 Выражение чувств:</strong> Невыраженные эмоции подобны буре, запертой внутри тесной комнаты.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>🤝 Поиск поддержки:</strong> Не стесняйся просить о помощи, особенно это касается мужчин.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>👥 Сообщества поддержки:</strong> Участие в группах создает чувство безопасности и принятия социума.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Ментальное здоровье --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'mental' ? '' : 'mental'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'mental' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🧠 Ментальное Здоровье</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'mental' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'mental'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>☀️ Позитивное мышление:</strong> Мы неизбежно становимся тем, о чем думаем больше всего.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5"><strong>📚 Обучение и развитие:</strong> Жизнь устроена просто — это либо постоянное развитие, либо деградация.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-emerald-500/5 sm:col-span-2"><strong>🧘‍♂️ Осознанность:</strong> Медитация и практики фокусировки — ценное умение быть здесь и сейчас.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Описание Безопасности -->
                <div x-show="activePillar === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-4 rounded-xl border border-blue-500/20 space-y-3"
                     x-data="{ openSub: 'personal' }">
                    <div class="flex items-center gap-2 text-blue-400">
                        <span class="text-lg">🛡️</span>
                        <x-h3 class="text-xs">Безопасность — Спокойствие Духа</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        Настоящая безопасность — это <span class="text-blue-400 font-semibold">«отсутствие постоянного страха за завтрашний день»</span>. Это финансовая, физическая и юридическая защита, которая избавляет мозг от стресса выживания.
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Личная безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'personal' ? '' : 'personal'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'personal' ? 'bg-blue-500/10 text-blue-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>👤 Личная Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'personal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'personal'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🏠 Безопасный район:</strong> Территория влияет на нас больше, чем мы думаем. Выбирай надежную среду обитания.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🛡️ Предотвращение угроз:</strong> Избегай заведомо опасных ситуаций. Лучшая битва — та, которая не состоялась.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2"><strong>🥋 Умение постоять за себя:</strong> Знания самообороны подобны страховке: лучше иметь и не нуждаться, чем нуждаться и не иметь.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Экономическая безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'economic' ? '' : 'economic'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'economic' ? 'bg-blue-500/10 text-blue-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>💰 Экономическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'economic' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'economic'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>📈 Стабильный доход:</strong> Наличие надежного и легального источника дохода, приносящего удовлетворение.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>💼 Подушка безопасности:</strong> Финансовый резерв, покрывающий минимум 6 месяцев твоих обычных расходов.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Юридическая безопасность --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'legal' ? '' : 'legal'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'legal' ? 'bg-blue-500/10 text-blue-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>⚖️ Юридическая Безопасность</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'legal' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'legal'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>📜 Знание своих прав:</strong> Понимай свои права, законы и правовые возможности. Знание законов освобождает от многих проблем.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5"><strong>🔑 Легальные статусы:</strong> Держи в порядке все необходимые доступы, разрешения, лицензии и документы.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2"><strong>💼 Законное ведение дел:</strong> Защита от злоумышленников через честный бизнес. Полный отказ от «серых» схем, срезания углов и мутных связей.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-blue-500/5 sm:col-span-2"><strong>✍️ Письменное оформление:</strong> Абсолютно любые сделки и отношения с физ. и юр. лицами фиксируй строго в письменном виде по закону.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Описание Свободы -->
                <div x-show="activePillar === 'freedom'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-4 rounded-xl border border-violet-500/20 space-y-3"
                     x-data="{ openSub: 'choice' }">
                    <div class="flex items-center gap-2 text-violet-400">
                        <span class="text-lg">🕊️</span>
                        <x-h3 class="text-xs">Свобода — Независимость Выбора</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-violet-400 font-semibold">«Свобода — это возможность не делать то, чего ты делать не хочешь»</span>. Свобода от чужих ожиданий, долгов и навязанного мнения. Настоящая свобода — это власть разума над страстями. Свободен лишь тот, кто желает лишь того, что находится в его полной личной воле
                    </x-p>

                    <div class="space-y-2 pt-1">
                        {{-- 1. Свобода Выбора --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'choice' ? '' : 'choice'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'choice' ? 'bg-violet-500/10 text-violet-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🕊️ Свобода Выбора</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'choice' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'choice'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🔍 Истинные желания:</strong> Осознавай свои истинные желания и потребности. Познай себя!</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>📖 Доступ к информации:</strong> Достоверные данные для обоснованных решений. Знание освобождает.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🛡️ Стойкость к давлению:</strong> Противостой манипуляциям и толпе. Будь хозяином своих решений!</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>⚖️ Ответственность:</strong> Бери на себя ответственность за свои выборы. Они неразделимы со свободой.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5 sm:col-span-2"><strong>🧠 Критическое мышление:</strong> Развивай критический ум. Никогда не верь слепо всему, что слышишь или читаешь.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5 sm:col-span-2"><strong>⚡ Действие:</strong> Свобода выбора реализуется только через реальные шаги и решения.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Свобода Самовыражения --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'expression' ? '' : 'expression'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'expression' ? 'bg-violet-500/10 text-violet-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🎨 Свобода Самовыражения</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'expression' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'expression'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>👤 Индивидуальность:</strong> Будь собой</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>💬 Конструктивные эмоции:</strong> Умей выражать свои эмоции без разрушительных последствий.</div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Личная Независимость --}}
                        <div class="rounded-xl border border-slate-800/60 overflow-hidden">
                            <button type="button" @click="openSub = openSub === 'independence' ? '' : 'independence'" class="w-full flex items-center justify-between px-3.5 py-2.5 text-left text-[11px] font-black uppercase tracking-wider transition-colors duration-200" :class="openSub === 'independence' ? 'bg-violet-500/10 text-violet-400' : 'bg-slate-950/40 text-slate-400 hover:text-slate-200'">
                                <span>🏔️ Личная Независимость</span>
                                <span class="text-[9px] transition-transform duration-200" :class="openSub === 'independence' && 'rotate-180'">▼</span>
                            </button>
                            <div x-show="openSub === 'independence'" x-collapse>
                                <div class="p-3 bg-slate-950/30 border-t border-slate-800/40 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-sans text-slate-300">
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🧘‍♂️ Самодостаточность:</strong> Развивай умение быть глубоко счастливым наедине с собой.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>💰 Финансовая независимость:</strong> Деньги не гарантируют счастья, но дают свободу выбора.</div>
                                    <div class="bg-slate-900/50 p-2.5 rounded-lg border border-violet-500/5"><strong>🛠️ Решение проблем:</strong> Самостоятельно преодолевай преграды. Каждая победа делает тебя сильнее.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Описание Близких -->
                <div x-show="activePillar === 'family'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-rose-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-rose-400">
                        <span class="text-lg">❤️</span>
                        <x-h3 class="text-xs">Близкие Люди — Тепло и Окружение</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        <span class="text-rose-400 font-semibold">«Отношения — это сад, его нужно поливать каждый день»</span>. Окружай себя донаторами энергии, цени верность и дари любовь в ответ. Крепкие социальные связи запускают мощную выработку окситоцина (гормона доверия, спокойствия и привязанности). Общение с любимыми снижает стресс на биологическом уровне.
                    </x-p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-rose-400">🌱</span>
                            <span><strong>Качество, а не количество:</strong> Достаточно иметь 3–5 глубоких, искренних связей. Избавляйся от токсичных отношений («вампиров»), сосущих твой ресурс.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-rose-400">🤝</span>
                            <span>Мы рождены друг для друга. Заботься об общем благе и поддерживай близких — в этом проявляется справедливость.</span>
                        </div>
                    </div>
                </div>

                <!-- Описание Любимого Дела -->
                <div x-show="activePillar === 'work'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-950/60 p-5 rounded-xl border border-amber-500/20 space-y-3">
                    <div class="flex items-center gap-2 text-amber-400">
                        <span class="text-lg">🎯</span>
                        <x-h3 class="text-xs">Любимое Дело — Поток и Полезность</x-h3>
                    </div>
                    <x-p class="text-slate-300">
                        Любимое дело дает ключевое чувство: <span class="text-amber-400 font-semibold">«осознание нужности своего существования»</span>. Это работа в состоянии Потока, когда ты сфокусирован на пользе людям и качестве процесса, а не только на деньгах.
                    </x-p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 text-[11px] font-sans text-slate-400">
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-amber-400">🎯</span>
                            <span><strong>Философия Kaizen:</strong> Маленькие шаги (+1% в день) в твоем ремесле ведут к величию. Наслаждайся процессом оттачивания мастерства.</span>
                        </div>
                        <div class="flex gap-2 items-start bg-slate-900/50 p-2.5 rounded-lg">
                            <span class="text-amber-400">🛠️</span>
                            <span>Делай то, что велит твой долг и природа, делай это превосходно на благо всего общества.</span>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>


        <!-- ================= РАЗДЕЛ 1: БАЗОВЫЕ ПРАВИЛА ================= -->
        <div class="space-y-3.5">
            <x-h2>⚔️ Базовый кодекс жизни</x-h2>
            <div class="grid grid-cols-1 gap-3.5">
                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 1 ? null : 1">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">👔</span>
                                <div>
                                    <x-h3>Внешний вид</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Сила первого впечатления, базовые цвета и уход за обувью</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 1 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 1" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Одежда по размеру — не мешком, не в обтяжку</li>
                                <li>Без принтов и кричащих логотипов — однотон = взрослый вид</li>
                                <li>Обувь чистая ВСЕГДА — люди смотрят на обувь</li>
                                <li>Гладь рубашки. Стирай кроссовки. Следи за состоянием вещей</li>
                                <li>Аксессуары: меньше = лучше. Часы > браслеты и цепочки</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 2 ? null : 2">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">🗣️</span>
                                <div>
                                    <x-h3>Речь</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Уверенность в общении, дикция и избавление от слов-паразитов</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 2 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 2" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Говори медленнее — быстрая речь = нервозность</li>
                                <li>Убери слова-паразиты: «ну», «типа», «короче», «как бы»</li>
                                <li>Не оправдывайся</li>
                                <li>Не извиняйся без причины</li>
                                <li>Читай вслух — тренировка дикции и словарного запаса</li>
                                <li>Не перебивай. Не жалуйся. Не матерись через слово</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 3 ? null : 3">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">🏋️</span>
                                <div>
                                    <x-h3>Тело и здоровье</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Гигиена, осанка, базовый баланс сна и питания</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 3 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 3" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Душ каждый день, дезодорант — обязательно</li>
                                <li>Чистые ногти, зубы 2 раза в день, уход за кожей</li>
                                <li>Стрижка каждые 3–4 недели</li>
                                <li>Осанка: плечи назад, грудь вперёд, подбородок параллельно полу</li>
                                <li>Стой у стены 2 мин/день (затылок, лопатки, ягодицы, пятки)</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 4 ? null : 4">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">🧠</span>
                                <div>
                                    <x-h3>Интеллект</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Критическое мышление, привычка к чтению и цифровая гигиена</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 4 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 4" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Формируй СВОЁ мнение, не повторяй чужие из тиктока</li>
                                <li>Критическое мышление: «Где доказательства? Кому выгодно?»</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 5 ? null : 5">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">🤝</span>
                                <div>
                                    <x-h3>Социалка</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Правила хорошего тона, пунктуальность и сила данного слова</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 5 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 5" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Смотри в глаза при разговоре — мягко и уверенно</li>
                                <li>Будь пунктуальным — приходи на 5 мин раньше</li>
                                <li>Помогай без ожидания ответа</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 6 ? null : 6">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">🏠</span>
                                <div>
                                    <x-h3>Быт</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Порядок в доме, дисциплина в мелочах и кулинарные навыки</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 6 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 6" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Заправил кровать каждое утро (30 сек → тон дня)</li>
                                <li>Не копи грязную посуду</li>
                                <li>Выброси хлам: не используешь 6 мес → не нужно</li>
                                <li>Проветривай комнату. Приятный запах</li>
                                <li>Умей готовить 5 блюд: яичница, паста, рис+мясо, салат, суп</li>
                            </ul>
                        </div>
                    </x-card>

                    <x-card hover>
                        <!-- Шапка категории -->
                        <div class="cursor-pointer flex justify-between items-center"
                            x-on:click="activeCategory = activeCategory === 7 ? null : 7">
                            <div class="flex items-center gap-3">
                                <span class="text-xl bg-slate-950/80 w-10 h-10 rounded-xl flex items-center justify-center">⚔️</span>
                                <div>
                                    <x-h3>Дисциплина</x-h3>
                                    <x-p class="text-slate-400 mt-0.5">Управление эмоциями, лидерство и преодоление лени</x-p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 transform transition-transform duration-200"
                                :class="activeCategory === 7 ? 'rotate-180' : ''">▼</span>
                        </div>
                        <!-- Раскрывающиеся правила -->
                        <div x-show="activeCategory === 7" x-collapse class="mt-4 pt-4 border-t border-slate-950">
                            <ul class="list-disc pl-5 space-y-2.5 text-slate-300 text-sm font-sans marker:text-indigo-500">
                                <li>Делай то, что нужно, даже когда не хочется</li>
                                <li>Признавай ошибки быстро и без оправданий</li>
                                <li>Не жалуйся — решай проблему или прими её</li>
                                <li>Контролируй реакции — ты не контролируешь мир, но контролируешь себя</li>
                                <li>Будь спокоен под давлением — это отличает лидера от толпы</li>
                            </ul>
                        </div>
                    </x-card>
            </div>
            
        </div>
        <div class="space-y-3.5 pt-4">
            <x-h2>📖 База знаний</x-h2>

            <div x-data="{ activeTab: null }" class="grid grid-cols-1 gap-3.5">

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
                                        <li>• Гречка, рис, овсянка</li>
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

    </div>
</x-app-layout>

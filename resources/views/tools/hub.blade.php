        <!-- ================= ЭКРАН 1: ГЛАВНЫЙ ХАБ ИНСТРУМЕНТОВ ================= -->
        <template x-if="currentTab === 'hub'">
            <div class="space-y-6">
                <!-- Заголовок Хаба -->
                <div class="pb-4 border-b border-slate-200">
                    <x-h1>🛠️ Инструменты</x-h1>
                    <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Полезные утилиты и персональные помощники</x-p>
                </div>

                <!-- Список инструментов -->
                <div class="space-y-4">

                    <!-- КНОПКА: КВЕСТЫ -->
                    <button @click="currentTab = 'quests'" 
                            class="w-full bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-sky-400/50 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-[0_2px_12px_rgba(15,23,42,0.03)] hover:shadow-[0_8px_25px_rgba(14,165,233,0.08)] group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-sky-500/5 rounded-full blur-xl group-hover:bg-sky-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-100 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-200">⚔️</span>
                            <div>
                                <x-h3 class="text-slate-900 font-bold group-hover:text-sky-600 transition-colors">Задачи</x-h3>
                                <x-p class="text-slate-600 mt-1">Ежедневные задачи и цели на сегодня.</x-p>
                            </div>
                        </div>
                    </button>
                    
                    <!-- КНОПКА: РЫНОЧНЫЙ ТЕРМИНАЛ -->
                    <button @click="goToTerminal()" 
                            class="w-full bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-indigo-400/50 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-[0_2px_12px_rgba(15,23,42,0.03)] hover:shadow-[0_8px_25px_rgba(99,102,241,0.08)] group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-100 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-200">📈</span>
                            <div>
                                <x-h3 class="text-indigo-700 font-bold group-hover:text-indigo-800 transition-colors">Рыночный терминал</x-h3>
                                <x-p class="text-slate-600 mt-1">Курсы в реальном времени.</x-p>
                            </div>
                        </div>
                    </button>

                    <!-- КНОПКА: ЗАЛ -->
                    <a href="{{ route('workouts.index') }}" 
                       class="w-full bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-rose-400/50 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-[0_2px_12px_rgba(15,23,42,0.03)] hover:shadow-[0_8px_25px_rgba(244,63,94,0.08)] group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-100 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-200">🏋️</span>
                            <div>
                                <x-h3 class="text-slate-900 font-bold group-hover:text-rose-600 transition-colors">Тренировка</x-h3>
                                <x-p class="text-slate-600 mt-1">Программа тренировок, упражнения и отслеживание прогресса.</x-p>
                            </div>
                        </div>
                    </a>

                    <!-- КНОПКА: КОДЕКС -->
                    <a href="{{ route('codex') }}" 
                       class="w-full bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-violet-400/50 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-[0_2px_12px_rgba(15,23,42,0.03)] hover:shadow-[0_8px_25px_rgba(139,92,246,0.08)] group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-violet-500/5 rounded-full blur-xl group-hover:bg-violet-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-100 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-200">📜</span>
                            <div>
                                <x-h3 class="text-slate-900 font-bold group-hover:text-violet-600 transition-colors">Кодекс</x-h3>
                                <x-p class="text-slate-600 mt-1">Базовый кодекс жизни, столпы здоровья, безопасности и база знаний.</x-p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </template>

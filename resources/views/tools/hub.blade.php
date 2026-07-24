        <!-- ================= ЭКРАН 1: ГЛАВНЫЙ ХАБ ИНСТРУМЕНТОВ ================= -->
        <template x-if="currentTab === 'hub'">
            <div class="space-y-6">
                <!-- Заголовок Хаба -->
                <div class="pb-4 border-b border-slate-900/50">
                    <x-h1>🛠️ Инструменты</x-h1>
                    <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Полезные утилиты и персональные помощники</x-p>
                </div>

                <!-- Список инструментов -->
                <div class="space-y-4">
                    
                    <!-- КНОПКА: РЫНОЧНЫЙ ТЕРМИНАЛ -->
                    <button @click="goToTerminal()" 
                            class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-indigo-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">📈</span>
                            <div>
                                <x-h3 class="text-indigo-300 group-hover:text-indigo-200 transition-colors">Рыночный терминал</x-h3>
                                <x-p class="text-slate-400 mt-1">Курсы в реальном времени.</x-p>
                            </div>
                        </div>
                    </button>

                    <!-- КНОПКА: ВАЖНЫЕ ДАТЫ -->
                    <button @click="currentTab = 'events'" 
                            class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-indigo-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">📅</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-indigo-300 transition-colors">Важные даты</x-h3>
                                <x-p class="text-slate-400 mt-1">Система заблаговременных напоминаний о важных событиях.</x-p>
                            </div>
                        </div>
                    </button>
                    <!-- КНОПКА: ФИНАНСЫ -->
                    <button @click="currentTab = 'finance'" 
                            class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-amber-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">💰</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-amber-300 transition-colors">Финансы</x-h3>
                                <x-p class="text-slate-400 mt-1">Управление личным капиталом, доходами и расходами.</x-p>
                            </div>
                        </div>
                    </button>

                    <!-- КНОПКА: ЦЕЛИ И НАКОПЛЕНИЯ -->
                    <button @click="currentTab = 'goals'" 
                            class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-emerald-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">🎯</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-emerald-300 transition-colors">Жизненные цели</x-h3>
                                <x-p class="text-slate-400 mt-1">Управление вашими жизненными целями.</x-p>
                            </div>
                        </div>
                    </button>

                    <!-- КНОПКА: ВИДЕОТЕКА -->
                    <button @click="currentTab = 'videos'" 
                            class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-indigo-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">🎬</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-indigo-300 transition-colors">Видеотека</x-h3>
                                <x-p class="text-slate-400 mt-1">Обучающие видео, видеоматериалы и разборы.</x-p>
                            </div>
                        </div>
                    </button>

                    <!-- КНОПКА: ЗАЛ -->
                    <a href="{{ route('workouts.index') }}" 
                       class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-rose-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">🏋️</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-rose-300 transition-colors">Зал</x-h3>
                                <x-p class="text-slate-400 mt-1">Программа тренировок, упражнения и отслеживание прогресса.</x-p>
                            </div>
                        </div>
                    </a>

                    <!-- КНОПКА: КОДЕКС -->
                    <a href="{{ route('codex') }}" 
                       class="w-full bg-slate-900 hover:bg-slate-900/60 border border-slate-900 hover:border-violet-500/20 text-left rounded-2xl p-5 transition-all duration-200 cursor-pointer shadow-lg group relative overflow-hidden block">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-violet-500/5 rounded-full blur-xl group-hover:bg-violet-500/10 transition-all"></div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/80 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-850/50">📜</span>
                            <div>
                                <x-h3 class="text-slate-200 group-hover:text-violet-300 transition-colors">Кодекс</x-h3>
                                <x-p class="text-slate-400 mt-1">Базовый кодекс жизни, столпы здоровья, безопасности и база знаний.</x-p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </template>

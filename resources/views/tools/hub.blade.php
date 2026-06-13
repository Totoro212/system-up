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
                                <x-p class="text-slate-400 mt-1">Курсы BTC и USD к узбекскому суму (UZS) в реальном времени.</x-p>
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
                </div>
            </div>
        </template>

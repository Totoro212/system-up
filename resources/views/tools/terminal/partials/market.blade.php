        <!-- ================= ЭКРАН 2: РЫНОЧНЫЙ ТЕРМИНАЛ ================= -->
        <template x-if="currentTab === 'terminal'">
            <div class="space-y-6">
                <!-- Навигационная панель назад -->
                <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
                    <button @click="currentTab = 'hub'" 
                            class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                        <span>←</span>
                        <span>В Инструменты</span>
                    </button>

                    <!-- Статус и Кнопка Обновить -->
                    <div class="flex items-center gap-3">
                        <button @click="refreshRates()" :disabled="loading"
                                class="flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition-all duration-200 cursor-pointer shadow-lg shadow-indigo-950/40 hover:-translate-y-0.5 disabled:opacity-50">
                            <span :class="loading ? 'animate-spin' : ''" class="inline-block text-xs">🔄</span>
                        </button>
                    </div>
                </div>

                <!-- Заголовок страницы -->
                <div>
                    <x-h1>Рынки</x-h1>
                    <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Рыночный терминал в реальном времени</x-p>
                </div>

                <!-- Сетка карточек с котировками -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- КАРТОЧКА: BITCOIN -->
                    <x-card class="bg-slate-900 border-slate-850/80 shadow-2xl relative overflow-hidden flex flex-col justify-between min-h-[160px]">
                        <div class="absolute -right-6 -top-6 w-20 h-20 bg-amber-500/5 rounded-full blur-xl"></div>
                        
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest">💰 BITCOIN (BTC/USDT)</span>
                                <span class="text-[10px] font-bold text-slate-500" x-text="btcChange">--</span>
                            </div>
                            
                            <div class="mt-4">
                                <div class="text-2xl sm:text-3xl font-black text-slate-100 tracking-tight font-mono" x-text="btcPriceFormatted">
                                    Загрузка...
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-1" x-text="btcInUzsFormatted">--</p>
                            </div>
                        </div>
                    </x-card>

                    <!-- КАРТОЧКА: USD / UZS -->
                    <x-card class="bg-slate-900 border-slate-850/80 shadow-2xl relative overflow-hidden flex flex-col justify-between min-h-[160px]">
                        <div class="absolute -right-6 -top-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
                        
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">💵 ДОЛЛАР США (USD/UZS)</span>
                                <span class="text-[10px] font-bold text-emerald-400">Официальный</span>
                            </div>
                            
                            <div class="mt-4">
                                <div class="text-2xl sm:text-3xl font-black text-slate-100 tracking-tight font-mono" x-text="usdPriceFormatted">
                                    Загрузка...
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-1">Курс мирового валютного рынка</p>
                            </div>
                        </div>
                    </x-card>

                </div>

                <!-- Таймер обновления и Инфопанель -->
                <div class="bg-slate-900/40 border border-slate-900/60 rounded-2xl p-4 flex flex-wrap gap-4 justify-between items-center text-xs">
                    <div class="flex items-center gap-2 text-slate-400">
                        <span>🕒</span>
                        <span>Обновлено: <strong class="text-slate-200 font-mono" x-text="lastUpdated">--:--:--</strong></span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400">
                        <span>🔄</span>
                        <span>Автообновление через <strong class="text-indigo-400 font-mono" x-text="timer + 's'"></strong></span>
                    </div>
                </div>
            </div>
        </template>

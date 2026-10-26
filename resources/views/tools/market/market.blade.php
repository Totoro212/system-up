        <!-- ================= ЭКРАН 2: РЫНОЧНЫЙ ТЕРМИНАЛ ================= -->
        <template x-if="currentTab === 'terminal'">
            <div class="space-y-6">
                <!-- Навигационная панель назад -->
                <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                    <button @click="currentTab = 'hub'" 
                            class="text-[10px] font-extrabold text-indigo-600 hover:text-indigo-500 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-white px-3.5 py-2 rounded-xl border border-slate-200 hover:border-indigo-400 hover:-translate-y-0.5 transition-all shadow-sm">
                        <span>←</span>
                        <span>В Инструменты</span>
                    </button>

                    <!-- Статус и Кнопка Обновить -->
                    <div class="flex items-center gap-3">
                        <button @click="refreshRates()" :disabled="loading"
                                class="flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition-all duration-200 cursor-pointer shadow-md shadow-indigo-600/20 hover:-translate-y-0.5 disabled:opacity-50">
                            <span :class="loading ? 'animate-spin' : ''" class="inline-block text-xs">🔄</span>
                        </button>
                    </div>
                </div>

                <!-- Заголовок страницы -->
                <div>
                    <x-h1>Рынки</x-h1>
                    <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Рыночный терминал </x-p>
                </div>

                <!-- Сетка карточек с котировками -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- КАРТОЧКА: USD / UZS -->
                    <x-card class="bg-white border-slate-200/90 shadow-[0_4px_20px_rgba(15,23,42,0.04)] relative overflow-hidden flex flex-col justify-between min-h-[120px]">
                        <div class="absolute -right-6 -top-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
                        
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200/60 uppercase tracking-widest">💵 ДОЛЛАР</span>
                            </div>
                            
                            <div class="mt-4">
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-mono" x-text="usdPriceFormatted">
                                    Загрузка...
                                </div>
                            </div>
                        </div>
                    </x-card>

                </div>

                <!-- Таймер обновления и Инфопанель -->
                <div class="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-wrap gap-4 justify-between items-center text-xs shadow-sm">
                    <div class="flex items-center gap-2 text-slate-500">
                        <span>🕒</span>
                        <span>Обновлено: <strong class="text-slate-700 font-mono" x-text="lastUpdated">--:--:</strong></span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500">
                        <span>🔄</span>
                        <span>Автообновление через <strong class="text-indigo-600 font-mono" x-text="timer + 's'"></strong></span>
                    </div>
                </div>
            </div>
        </template>

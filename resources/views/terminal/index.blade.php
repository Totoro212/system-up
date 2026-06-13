<x-app-layout title='Пульт'>
    <div class="max-w-2xl mx-auto p-4 space-y-6 pb-20" x-data="marketTerminal()">

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

                    <!-- КНОПКА: ГЕНЕРАТОР ПАРОЛЕЙ (СКОРО) -->
                    <x-card class="border-slate-900/40 opacity-60 relative overflow-hidden">
                        <div class="absolute top-4 right-4 bg-slate-950 px-2 py-0.5 rounded text-[9px] font-extrabold text-slate-500 uppercase tracking-widest border border-slate-900">СКОРО</div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/40 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-900/50">🛡️</span>
                            <div>
                                <x-h3 class="text-slate-500">Генератор паролей</x-h3>
                                <x-p class="text-slate-500 mt-1">Создание надежных паролей с настройкой сложности для безопасности.</x-p>
                            </div>
                        </div>
                    </x-card>

                    <!-- КНОПКА: ФОКУС-ТАЙМЕР (СКОРО) -->
                    <x-card class="border-slate-900/40 opacity-60 relative overflow-hidden">
                        <div class="absolute top-4 right-4 bg-slate-950 px-2 py-0.5 rounded text-[9px] font-extrabold text-slate-500 uppercase tracking-widest border border-slate-900">СКОРО</div>
                        
                        <div class="flex items-center gap-3.5">
                            <span class="text-2xl bg-slate-950/40 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-900/50">⏱️</span>
                            <div>
                                <x-h3 class="text-slate-500">Фокус-таймер</x-h3>
                                <x-p class="text-slate-500 mt-1">Помодоро таймер для глубокой фокусировки на написании кода.</x-p>
                            </div>
                        </div>
                    </x-card>

                </div>
            </div>
        </template>


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

    </div>

    <!-- Клиентский скрипт для обновления котировок в реальном времени -->
    <script>
        function marketTerminal() {
            return {
                currentTab: 'hub', // 'hub' или 'terminal'
                btcPrice: null,
                btcPrevPrice: null,
                usdPrice: null,
                usdPrevPrice: null,
                loading: false,
                lastUpdated: '--:--:--',
                timer: 30,
                timerInterval: null,

                init() {
                    // Таймер тикает в фоновом режиме каждую секунду
                    this.timerInterval = setInterval(() => {
                        if (this.currentTab === 'terminal') {
                            this.timer--;
                            if (this.timer <= 0) {
                                this.refreshRates();
                            }
                        }
                    }, 1000);
                },

                goToTerminal() {
                    this.currentTab = 'terminal';
                    this.refreshRates();
                },

                get btcPriceFormatted() {
                    if (!this.btcPrice) return 'Загрузка...';
                    return '$' + parseFloat(this.btcPrice).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },

                get btcInUzsFormatted() {
                    if (!this.btcPrice || !this.usdPrice) return '--';
                    const uzsVal = this.btcPrice * this.usdPrice;
                    return '≈ ' + uzsVal.toLocaleString('ru-RU', { maximumFractionDigits: 0 }) + ' UZS';
                },

                get usdPriceFormatted() {
                    if (!this.usdPrice) return 'Загрузка...';
                    return this.usdPrice.toLocaleString('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' UZS';
                },

                get btcChange() {
                    if (!this.btcPrevPrice || !this.btcPrice) return '🟢 0.00%';
                    const diff = this.btcPrice - this.btcPrevPrice;
                    const percent = (diff / this.btcPrevPrice) * 100;
                    if (percent >= 0) {
                        return '🟢 +' + percent.toFixed(2) + '%';
                    } else {
                        return '🔴 ' + percent.toFixed(2) + '%';
                    }
                },

                async refreshRates() {
                    this.loading = true;
                    
                    try {
                        // 1. Загрузка курса Биткоина с Binance
                        const btcRes = await fetch('https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT');
                        if (btcRes.ok) {
                            const btcData = await btcRes.json();
                            const newBtcPrice = parseFloat(btcData.price);
                            if (this.btcPrice) {
                                this.btcPrevPrice = this.btcPrice;
                            } else {
                                this.btcPrevPrice = newBtcPrice;
                            }
                            this.btcPrice = newBtcPrice;
                        }

                        // 2. Загрузка курса доллара UZS
                        const usdRes = await fetch('https://open.er-api.com/v6/latest/USD');
                        if (usdRes.ok) {
                            const usdData = await usdRes.json();
                            const newUsdPrice = parseFloat(usdData.rates.UZS);
                            if (this.usdPrice) {
                                this.usdPrevPrice = this.usdPrice;
                            } else {
                                this.usdPrevPrice = newUsdPrice;
                            }
                            this.usdPrice = newUsdPrice;
                        }

                        // Запоминаем время обновления
                        const now = new Date();
                        this.lastUpdated = now.toTimeString().split(' ')[0];

                    } catch (error) {
                        console.error('Ошибка обновления котировок:', error);
                    } finally {
                        this.loading = false;
                        this.timer = 30; // сброс таймера
                    }
                },

            };
        }
    </script>
</x-app-layout>

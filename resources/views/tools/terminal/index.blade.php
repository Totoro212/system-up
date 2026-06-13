<x-app-layout title='Пульт'>
    <div class="max-w-2xl mx-auto p-4 space-y-6 pb-20" x-data="marketTerminal()">

        @include('tools.terminal.partials.hub')
        @include('tools.terminal.partials.market')
        @include('tools.events.events')
        @include('tools.finance.partials.funds')
        @include('tools.finance.partials.accounts')
        @include('tools.finance.partials.history')

        @include('tools.terminal.partials.modals')
        @include('tools.finance.partials.modals')

    </div>

    <!-- Клиентский скрипт для обновления котировок в реальном времени -->
    <script>
        function marketTerminal() {
            return {
                currentTab: localStorage.getItem('terminalTab') || 'hub', // 'hub', 'terminal', 'finance', 'events'
                btcPrice: null,
                btcPrevPrice: null,
                usdPrice: null,
                usdPrevPrice: null,
                loading: false,
                lastUpdated: '--:--:--',
                timer: 30,
                timerInterval: null,

                init() {
                    this.$watch('currentTab', (val) => {
                        localStorage.setItem('terminalTab', val);
                    });

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

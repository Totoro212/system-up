<x-app-layout title='Пульт'>
    <div class="max-w-2xl mx-auto p-4 space-y-6 pb-20" x-data="marketTerminal()">

        @include('tools.hub')
        @include('tools.quests.quests')
        @include('tools.market.market')
        @include('tools.events.events')
        @include('tools.finance.finance')
        @include('tools.goals.goals')

        @include('tools.events.modals')

    </div>

    <!-- Клиентский скрипт для обновления котировок в реальном времени -->
    <script>
        function marketTerminal() {
            return {
                currentTab: (localStorage.getItem('terminalTab') || 'hub'),
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
                    if (!this.btcPrice) return '';
                    return  parseInt(this.btcPrice).toLocaleString('en-US');
                },

                get usdPriceFormatted() {
                    if (!this.usdPrice) return 'Загрузка...';
                    return this.usdPrice.toLocaleString('ru-RU', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) + `,${Math.round(this.btcPrice)} UZS`;

                },

                async refreshRates() {
                    this.loading = true;
                    
                    try {
                        const btcRes = await fetch('https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT');
                        if (btcRes.ok) {
                            const btcData = await btcRes.json();
                            const newBtcPrice = parseFloat(btcData.price);
                            if (this.btcPrice) {
                                this.btcPrevPrice = this.btcPrice;
                            } else {
                                this.btcPrevPrice = newBtcPrice;
                            }
                            this.btcPrice = (newBtcPrice/1000);
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

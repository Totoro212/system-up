<!-- 1. ПОЛУЧИЛ (Доход) -->
<x-modal name="add-income" focusable>
    <form method="post" action="{{ route('finance.income.store') }}" class="p-6">
        @csrf
        <h2 class="text-xl font-black text-slate-100 mb-2">📥 Получил доход</h2>
        <p class="text-xs text-slate-400 mb-6">Добавьте новую сумму. По умолчанию деньги падают на главную карту (Uzum).</p>

        <div class="space-y-5">
            <div>
                <x-input-label for="amount" value="Сколько получили?" />
                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full text-lg font-bold" required />
            </div>

            <div>
                <x-input-label for="account_id" value="Куда упали деньги?" />
                <select name="account_id" id="account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                    <!-- Пытаемся поставить Uzum первым или выбранным по умолчанию, но пока просто выводим список -->
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ str_contains(strtolower($account->name), 'uzum') ? 'selected' : '' }}>
                            {{ $account->name }} ({{ $account->currency }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bg-indigo-500/10 border border-indigo-500/20 p-4 rounded-xl">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" name="is_salary" value="1" class="rounded border-slate-800 bg-slate-900 text-indigo-500 shadow-sm focus:ring-indigo-500 mt-1" checked>
                    <div>
                        <span class="block text-sm font-bold text-indigo-300">Это Основной доход (Зарплата)</span>
                        <span class="block text-[10px] text-slate-400 mt-1 leading-relaxed">Система сама раскидает эту сумму по вашим бюджетам (50% Нужды, 35% Желания, 10% Сбережения, 5% Семья). Снимите галочку, если это просто возврат долга или подарок.</span>
                    </div>
                </label>
            </div>
            
            <div>
                <x-input-label for="description" value="Комментарий (от кого?)" />
                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" placeholder="Например: Зарплата за май" />
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5">Отмена</x-secondary-button>
            <x-primary-button class="bg-emerald-600 hover:bg-emerald-500 py-2.5 px-6">Сохранить</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- 2. ПОТРАТИЛ (Расход) -->
<x-modal name="add-expense" focusable>
    <form method="post" action="{{ route('finance.expense.store') }}" class="p-6">
        @csrf
        <h2 class="text-xl font-black text-slate-100 mb-2">💸 Потратил деньги</h2>
        <p class="text-xs text-slate-400 mb-6">Списание физических денег с вашей карты и уменьшение лимита в нужном бюджете.</p>

        <div class="space-y-5">
            <div>
                <x-input-label for="amount_expense" value="Сколько потратили?" />
                <x-text-input id="amount_expense" name="amount" type="number" step="0.01" class="mt-1 block w-full text-lg font-bold" required />
            </div>

            <div>
                <x-input-label for="description_expense" value="На что? (Продукты, Кафе, Бензин)" />
                <x-text-input id="description_expense" name="description" type="text" class="mt-1 block w-full" placeholder="Например: Продукты в Корзинке" required />
            </div>

            <div>
                <x-input-label for="account_id_expense" value="Какой картой реально платили?" />
                <select name="account_id" id="account_id_expense" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ str_contains(strtolower($account->name), 'uzum') ? 'selected' : '' }}>
                            {{ $account->name }} ({{ $account->currency }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-500 mt-1">Отсюда уйдут физические деньги (например, Ipak Yuli ради кэшбека).</p>
            </div>

            <div>
                <x-input-label for="fund_id" value="Из какого бюджета (конверта) вычесть лимит?" />
                <select name="fund_id" id="fund_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                    @foreach($funds as $fund)
                        <option value="{{ $fund->id }}">{{ $fund->icon }} {{ $fund->name }} (Доступно: {{ number_format($fund->balance, 0, '.', ' ') }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5">Отмена</x-secondary-button>
            <x-primary-button class="bg-rose-600 hover:bg-rose-500 py-2.5 px-6">Списать</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- 3. ПЕРЕМЕСТИЛ (Перевод) -->
<x-modal name="transfer-money" focusable>
    <form method="post" action="{{ route('finance.transfer') }}" class="p-6">
        @csrf
        <h2 class="text-xl font-black text-slate-100 mb-2">🔁 Переложил деньги</h2>
        <p class="text-xs text-slate-400 mb-6">Скинул с карты на карту или снял наличку. Ваши бюджеты (лимиты) от этого не меняются!</p>

        <div class="space-y-5">
            <div>
                <x-input-label for="amount_transfer" value="Сумма перевода" />
                <x-text-input id="amount_transfer" name="amount" type="number" step="0.01" class="mt-1 block w-full text-lg font-bold" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="from_account_id" value="Откуда (Карман 1)" />
                    <select name="from_account_id" id="from_account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ str_contains(strtolower($account->name), 'uzum') ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="to_account_id" value="Куда (Карман 2)" />
                    <select name="to_account_id" id="to_account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5">Отмена</x-secondary-button>
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 py-2.5 px-6">Перевести</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- 4. НАСТРОЙКА % ФОНДОВ (Шестеренка) -->
<x-modal name="edit-funds" focusable>
    <form method="post" action="{{ route('finance.funds.update') }}" class="p-6">
        @csrf
        <h2 class="text-xl font-black text-slate-100 mb-2">⚙️ Настройка процентов</h2>
        <p class="text-xs text-slate-400 mb-6">Распределите 100% между вашими фондами. Если поставить 0%, фонд не будет пополняться автоматически при зарплате.</p>

        <div class="space-y-5">
            @foreach($funds as $fund)
                <div>
                    <x-input-label for="fund_{{ $fund->id }}" value="{{ $fund->icon }} {{ $fund->name }} (%)" />
                    <x-text-input id="fund_{{ $fund->id }}" name="percentages[{{ $fund->id }}]" type="number" step="1" min="0" max="100" class="mt-1 block w-full text-lg font-bold" value="{{ $fund->target_percentage }}" required />
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5">Отмена</x-secondary-button>
            <x-primary-button class="bg-slate-700 hover:bg-slate-600 py-2.5 px-6">Сохранить</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- 5. ДОБАВИТЬ НОВЫЙ СЧЕТ/КАРТУ -->
<x-modal name="add-account" focusable>
    <form method="post" action="{{ route('finance.account.store') }}" class="p-6">
        @csrf
        <h2 class="text-xl font-black text-slate-100 mb-2">💳 Добавить новый счет</h2>
        <p class="text-xs text-slate-400 mb-6">Создайте новую карту, вклад или место для наличных.</p>

        <div class="space-y-5">
            <div>
                <x-input-label for="acc_name" value="Название (например: Карта Капиталбанк)" />
                <x-text-input id="acc_name" name="name" type="text" class="mt-1 block w-full" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="acc_type" value="Тип счета" />
                    <select name="type" id="acc_type" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                        <option value="card">Карта</option>
                        <option value="cash">Наличные</option>
                        <option value="deposit">Вклад</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="acc_currency" value="Валюта" />
                    <select name="currency" id="acc_currency" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm py-3" required>
                        <option value="UZS">Сум (UZS)</option>
                        <option value="USD">Доллар (USD)</option>
                    </select>
                </div>
            </div>

            <div>
                <x-input-label for="acc_balance" value="Текущий остаток" />
                <x-text-input id="acc_balance" name="balance" type="number" step="0.01" class="mt-1 block w-full text-lg font-bold" value="0" required />
            </div>

            <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-xl">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_joint" value="1" class="rounded border-slate-800 bg-slate-900 text-rose-500 shadow-sm focus:ring-rose-500">
                    <span class="block text-sm font-bold text-rose-300">Это Общий (Семейный) счет</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5">Отмена</x-secondary-button>
            <x-primary-button class="bg-emerald-600 hover:bg-emerald-500 py-2.5 px-6">Добавить</x-primary-button>
        </div>
    </form>
</x-modal>

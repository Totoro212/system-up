<!-- Добавить Доход -->
<x-modal name="add-income" focusable>
    <form method="post" action="{{ route('finance.income.store') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-medium text-slate-100 mb-4">
            💸 Поступление дохода
        </h2>
        <p class="text-xs text-slate-400 mb-4">
            Система автоматически распределит эту сумму по фондам (50% Нужды, 40% Желания, 10% Сбережения).
        </p>

        <div class="space-y-4">
            <div>
                <x-input-label for="amount" value="Сумма" />
                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-input-label for="account_id" value="Куда поступили деньги? (Счет)" />
                <select name="account_id" id="account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->currency }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="description" value="Описание (необязательно)" />
                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" placeholder="Например: Зарплата" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Отмена</x-secondary-button>
            <x-primary-button class="ml-3 bg-emerald-600 hover:bg-emerald-500">Добавить доход</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- Добавить Расход -->
<x-modal name="add-expense" focusable>
    <form method="post" action="{{ route('finance.expense.store') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-medium text-slate-100 mb-4">
            📉 Записать расход
        </h2>

        <div class="space-y-4">
            <div>
                <x-input-label for="amount_expense" value="Сумма" />
                <x-text-input id="amount_expense" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-input-label for="fund_id" value="Из какого фонда тратим?" />
                <select name="fund_id" id="fund_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm" required>
                    @foreach($funds as $fund)
                        <option value="{{ $fund->id }}">{{ $fund->icon }} {{ $fund->name }} ({{ $fund->currency }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="account_id_expense" value="С какой карты оплатили?" />
                <select name="account_id" id="account_id_expense" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->currency }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="description_expense" value="Описание (На что потратили?)" />
                <x-text-input id="description_expense" name="description" type="text" class="mt-1 block w-full" required />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Отмена</x-secondary-button>
            <x-primary-button class="ml-3 bg-rose-600 hover:bg-rose-500">Записать расход</x-primary-button>
        </div>
    </form>
</x-modal>

<!-- Перевод -->
<x-modal name="transfer-money" focusable>
    <form method="post" action="{{ route('finance.transfer') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-medium text-slate-100 mb-4">
            🔁 Перевод между своими счетами
        </h2>
        <p class="text-xs text-slate-400 mb-4">
            Это действие не меняет виртуальные фонды. Оно просто перемещает деньги физически (например, вы сняли наличку с карты).
        </p>

        <div class="space-y-4">
            <div>
                <x-input-label for="amount_transfer" value="Сумма" />
                <x-text-input id="amount_transfer" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="from_account_id" value="Откуда" />
                    <select name="from_account_id" id="from_account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="to_account_id" value="Куда" />
                    <select name="to_account_id" id="to_account_id" class="mt-1 block w-full bg-slate-950 border-slate-800 text-slate-100 rounded-xl text-sm" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Отмена</x-secondary-button>
            <x-primary-button class="ml-3">Перевести</x-primary-button>
        </div>
    </form>
</x-modal>

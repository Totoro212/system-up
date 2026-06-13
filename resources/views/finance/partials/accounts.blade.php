<x-card>
    <div class="flex justify-between items-center mb-4">
        <x-h2>💳 Физические счета</x-h2>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'transfer-money')" class="text-xs text-slate-400 hover:text-white bg-slate-800/50 px-2 py-1 rounded transition">
            <i class="fa-solid fa-right-left mr-1"></i> Перевод
        </button>
    </div>

    <div class="space-y-3">
        @forelse($accounts as $account)
            <div class="bg-slate-900/50 border border-slate-700/50 rounded-xl p-3 flex justify-between items-center">
                <div>
                    <div class="font-semibold text-sm text-slate-200">
                        @if($account->type === 'card') 💳 
                        @elseif($account->type === 'cash') 💵 
                        @elseif($account->type === 'deposit') 🏦 
                        @endif
                        {{ $account->name }}
                        @if($account->is_joint)
                            <span class="ml-1 text-[10px] bg-purple-500/20 text-purple-400 px-1.5 py-0.5 rounded-full">Общее</span>
                        @endif
                    </div>
                    @if($account->cashback_note)
                        <div class="text-[10px] text-emerald-400/80 mt-0.5">{{ $account->cashback_note }}</div>
                    @endif
                </div>
                <div class="text-right">
                    <div class="font-mono font-black text-sm text-white">
                        {{ number_format($account->balance, 0, '.', ' ') }} <span class="text-xs text-slate-500">{{ $account->currency }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-sm text-slate-500 text-center py-4">Нет добавленных счетов</div>
        @endforelse
    </div>
</x-card>

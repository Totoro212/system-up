<x-card class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <x-h2>📜 История операций</x-h2>
    </div>

    <div class="space-y-3">
        @forelse($transactions as $transaction)
            <div class="flex justify-between items-center bg-slate-900/40 p-3 rounded-xl border border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $transaction->type === 'income' ? 'bg-emerald-500/10 text-emerald-400' : ($transaction->type === 'expense' ? 'bg-rose-500/10 text-rose-400' : 'bg-indigo-500/10 text-indigo-400') }}">
                        @if($transaction->type === 'income')
                            <i class="fa-solid fa-arrow-down"></i>
                        @elseif($transaction->type === 'expense')
                            <i class="fa-solid fa-arrow-up"></i>
                        @else
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-200">
                            {{ $transaction->description ?: ($transaction->type === 'income' ? 'Пополнение' : ($transaction->type === 'expense' ? 'Расход' : 'Перевод')) }}
                        </div>
                        <div class="text-[10px] text-slate-500 font-mono">
                            {{ $transaction->created_at->format('d.m.Y H:i') }} • 
                            @if($transaction->type === 'income' || $transaction->type === 'expense')
                                {{ $transaction->account->name ?? 'Счет' }}
                            @else
                                {{ $transaction->account->name ?? 'Счет' }} → {{ $transaction->destinationAccount->name ?? 'Счет' }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="font-mono font-black {{ $transaction->type === 'income' ? 'text-emerald-400' : ($transaction->type === 'expense' ? 'text-rose-400' : 'text-slate-300') }}">
                    {{ $transaction->type === 'expense' ? '-' : ($transaction->type === 'income' ? '+' : '') }}{{ number_format($transaction->amount, 0, '.', ' ') }} <span class="text-xs opacity-50">{{ $transaction->currency }}</span>
                </div>
            </div>
        @empty
            <div class="text-sm text-slate-500 text-center py-4">Операций пока нет.</div>
        @endforelse
    </div>
</x-card>
</div>
</template>

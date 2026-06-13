<x-card>
    <div class="flex justify-between items-center mb-6">
        <x-h2>🎯 Виртуальные фонды (50/40/10)</x-h2>
        <div class="space-x-2">
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-income')" class="bg-emerald-600 hover:bg-emerald-500">
                <i class="fa-solid fa-plus mr-1"></i> Доход
            </x-primary-button>
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-expense')" class="bg-rose-600 hover:bg-rose-500">
                <i class="fa-solid fa-minus mr-1"></i> Расход
            </x-primary-button>
        </div>
    </div>

    <div class="space-y-5">
        @forelse($funds as $fund)
            <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700/50">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <span class="text-xl mr-2">{{ $fund->icon ?? '💰' }}</span>
                        <div>
                            <div class="font-bold text-slate-200 text-sm">{{ $fund->name }}</div>
                            @if($fund->target_percentage)
                                <div class="text-[10px] text-slate-500 font-mono tracking-wider">ЦЕЛЬ: {{ $fund->target_percentage }}% ОТ ДОХОДА</div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-mono font-black text-lg {{ $fund->color ? 'text-'.$fund->color.'-400' : 'text-white' }}">
                            {{ number_format($fund->balance, 0, '.', ' ') }} <span class="text-xs text-slate-500">{{ $fund->currency }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Progress bar or visual indicator could go here -->
            </div>
        @empty
            <div class="text-sm text-slate-500 text-center py-4">Нет добавленных фондов</div>
        @endforelse
    </div>
</x-card>

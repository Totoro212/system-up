<!-- ================= ЭКРАН 3: ФИНАНСЫ ================= -->
<template x-if="currentTab === 'finance'">
    <div class="space-y-6">
        
        <!-- Шапка -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-900/50">
            <button @click="currentTab = 'hub'" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <div class="text-right">
                <x-h2>💰 Финансы</x-h2>
                <x-p class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-1">Управление капиталом</x-p>
            </div>
        </div>

        <!-- Контент -->
        <x-card class="bg-slate-900/20 border-slate-900/50 text-center py-12 px-6 space-y-4">
            <span class="text-3xl block">🚧</span>
            <x-h2>Раздел в разработке</x-h2>
            <x-p class="text-slate-500 max-w-sm mx-auto">
                Здесь будет полноценная система учета доходов, расходов и управления личным капиталом.
            </x-p>
        </x-card>

    </div>
</template>

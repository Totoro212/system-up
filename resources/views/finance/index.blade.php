<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Финансы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Счета (Левая колонка, 1/3 ширины) -->
                <div class="lg:col-span-1 space-y-6">
                    @include('finance.partials.accounts')
                </div>

                <!-- Фонды (Правая колонка, 2/3 ширины) -->
                <div class="lg:col-span-2 space-y-6">
                    @include('finance.partials.funds')
                </div>
            </div>

        </div>
    </div>

    <!-- Модальные окна -->
    @include('finance.partials.modals')
</x-app-layout>

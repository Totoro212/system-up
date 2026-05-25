<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-slate-100 uppercase tracking-wide">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-xs text-slate-400">
            Действие является необратимым. Пожалуйста, внимательно ознакомьтесь с последствиями перед тем, как продолжить.
        </p>
    </header>

    <!-- Игровая панель предупреждения (Warning Alert Panel) -->
    <div class="bg-red-950/25 border border-red-900/50 rounded-xl p-5 space-y-3">
        <div class="flex items-center gap-2 text-red-400 font-bold text-xs uppercase tracking-wider">
            <span>🚨</span>
            <span>Критическое предупреждение</span>
        </div>
        <ul class="space-y-2 text-xs text-slate-300">
            <li class="flex items-start gap-2">
                <span class="text-red-500 font-bold">•</span>
                <span>Все ваши созданные квесты, привычки и история прогресса будут стерты навсегда.</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-red-500 font-bold">•</span>
                <span>Вы будете мгновенно разлогинены, а все активные сессии будут аннулированы.</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-red-500 font-bold">•</span>
                <span>Мы не храним архивы удаленных пользователей, восстановление данных будет невозможно.</span>
            </li>
        </ul>
    </div>

    <!-- Кнопка удаления -->
    <div class="pt-2">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="w-full sm:w-auto text-center justify-center"
        >
            {{ __('Delete Account') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-100 uppercase tracking-wide">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-xs text-slate-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

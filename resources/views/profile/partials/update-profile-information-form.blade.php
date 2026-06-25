<section>
    <header>
        <h2 class="text-lg font-bold text-slate-100 uppercase tracking-wide">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-xs text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    @if (Route::has('verification.send'))
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-850">
                        {{ __('Your email address is unverified.') }}

                        @if (Route::has('verification.send'))
                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        @endif
                    </p>

                    @if (session('status') === 'verification-link-sent' && Route::has('verification.send'))
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="telegram_chat_id" value="Telegram Chat ID" />
            <x-text-input id="telegram_chat_id" name="telegram_chat_id" type="text" class="mt-1 block w-full" :value="old('telegram_chat_id', $user->telegram_chat_id)" placeholder="Например: 123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('telegram_chat_id')" />
            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                Необходимо для отправки регулярных напоминаний (вода, разминка, глаза) в Telegram.<br>
                Свой Chat ID можно узнать у ботов <a href="https://t.me/userinfobot" target="_blank" class="text-indigo-400 hover:underline">@userinfobot</a> или <a href="https://t.me/cidbot" target="_blank" class="text-indigo-400 hover:underline">@cidbot</a>. Убедитесь, что вы предварительно запустили (нажали /start) вашего бота.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-indigo-400 font-bold uppercase tracking-wider"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

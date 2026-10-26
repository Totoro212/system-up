<x-app-layout title='Профиль'>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8" x-data="{ activeTab: 'info' }">
        
        <!-- Заголовок страницы и Табы -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-2 border-b border-slate-200">
            <div>
                <h1 class="text-3xl font-black tracking-widest text-slate-900 uppercase">Настройки</h1>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mt-1">Управление аккаунтом</p>
            </div>

            <!-- Вкладки управления (Табы) + Выход -->
            <div class="flex items-center gap-3 self-start md:self-auto flex-wrap">
                <div class="flex bg-slate-100 border border-slate-200 p-1 rounded-xl shadow-sm">
                    <button @click="activeTab = 'info'" 
                            :class="activeTab === 'info' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                        👤 Инфо
                    </button>
                    <button @click="activeTab = 'password'" 
                            :class="activeTab === 'password' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                        🔑 Пароль
                    </button>
                    <button @click="activeTab = 'delete'" 
                            :class="activeTab === 'delete' ? 'bg-rose-600 text-white shadow-md shadow-rose-600/20' : 'text-slate-600 hover:text-rose-700'"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                        ⚠️ Удаление
                    </button>
                </div>
            </div>

                <!-- Премиальная кнопка Выхода -->
                <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 hover:border-rose-300 text-xs font-extrabold uppercase tracking-wider rounded-xl transition-all duration-200 cursor-pointer flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                        </svg>
                        Выйти
                    </button>
                </form>
        </div>

        <!-- Контент вкладок с плавной анимацией в единой карточке -->
        <div class="p-6 sm:p-8 bg-white border border-slate-200/90 shadow-[0_4px_24px_rgba(15,23,42,0.04)] rounded-2xl transition-all duration-300">
            
            <!-- Вкладка 1: Информация профиля -->
            <div x-show="activeTab === 'info'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Вкладка 2: Изменение пароля -->
            <div x-show="activeTab === 'password'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="max-w-xl" 
                 style="display: none;">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Вкладка 3: Удаление аккаунта -->
            <div x-show="activeTab === 'delete'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="max-w-xl" 
                 style="display: none;">
                @include('profile.partials.delete-user-form')
            </div>

        </div>

    </div>
</x-app-layout>

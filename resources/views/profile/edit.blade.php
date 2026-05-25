<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8" x-data="{ activeTab: 'info' }">
        
        <!-- Заголовок страницы и Табы -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-2 border-b border-slate-900/50">
            <div>
                <h1 class="text-3xl font-black tracking-widest bg-gradient-to-r from-slate-100 to-slate-400 bg-clip-text text-transparent uppercase">Настройки</h1>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mt-1">Управление аккаунтом</p>
            </div>

            <!-- Вкладки управления (Табы) -->
            <div class="flex bg-slate-950/80 border border-slate-900 p-1 rounded-xl backdrop-blur-md self-start md:self-auto shadow-2xl">
                <button @click="activeTab = 'info'" 
                        :class="activeTab === 'info' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-950/30' : 'text-slate-400 hover:text-slate-200'"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                    👤 Инфо
                </button>
                <button @click="activeTab = 'password'" 
                        :class="activeTab === 'password' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-950/30' : 'text-slate-400 hover:text-slate-200'"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                    🔑 Пароль
                </button>
                <button @click="activeTab = 'delete'" 
                        :class="activeTab === 'delete' ? 'bg-red-600/90 text-white shadow-lg shadow-red-950/30' : 'text-slate-400 hover:text-red-400'"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 cursor-pointer">
                    ⚠️ Удаление
                </button>
            </div>
        </div>

        <!-- Контент вкладок с плавной анимацией в единой карточке -->
        <div class="p-6 sm:p-8 bg-slate-900/40 border border-slate-900 backdrop-blur-md shadow-2xl rounded-2xl transition-all duration-300">
            
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

        <!-- ================= ПРЕМИАЛЬНЫЙ СТЕКЛЯННЫЙ НИЖНИЙ ДОК ================= -->
        <nav class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/65 border border-slate-800/50 px-6 py-2.5 rounded-2xl backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.55)] flex items-center gap-8 z-50 max-w-[95%] sm:max-w-none transition-all duration-300">

            <!-- Квесты -->
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="12" cy="12" r="6"/>
                        <circle cx="12" cy="12" r="2"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">Квесты</span>
                <span class="w-1 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-indigo-400 shadow-[0_0_8px_#818cf8]' : 'bg-transparent' }}"></span>
            </a>

            <!-- Тренировки -->
            <a href="{{ route('workouts.index') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('workouts.index') || request()->routeIs('workouts.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.5 10.5h11M6.5 13.5h11M3 8v8a2 2 0 0 0 2 2h1.5v-12H5a2 2 0 0 0 -2 2zm14.5-2v12H19a2 2 0 0 0 2-2V8a2 2 0 0 0 -2 -2z"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('workouts.index') || request()->routeIs('workouts.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">Зал</span>
                <span class="w-1 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('workouts.index') || request()->routeIs('workouts.*') ? 'bg-indigo-400 shadow-[0_0_8px_#818cf8]' : 'bg-transparent' }}"></span>
            </a>

            <!-- Кодекс -->
            <a href="{{ route('codex') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('codex') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 19.5c0-.8.7-1.5 1.5-1.5H20M4 19.5c0 .8.7 1.5 1.5 1.5H20M4 19.5V3.5c0-.8.7-1.5 1.5-1.5H20v16.5"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('codex') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">Кодекс</span>
                <span class="w-1 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('codex') ? 'bg-indigo-400 shadow-[0_0_8px_#818cf8]' : 'bg-transparent' }}"></span>
            </a>

            <!-- Инструменты -->
            <a href="{{ route('terminal') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('terminal') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="m5 7 5 5-5 5M12 17h8"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('terminal') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">Пульт</span>


            <!-- Профиль -->
            <a href="{{ route('profile.edit') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('profile.edit') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('profile.edit') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}">Профиль</span>
                <span class="w-1 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('profile.edit') ? 'bg-indigo-400 shadow-[0_0_8px_#818cf8]' : 'bg-transparent' }}"></span>
            </a>

        </nav>
        <!-- =================================================================== -->
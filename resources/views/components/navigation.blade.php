        <!-- ================= ПРЕМИАЛЬНЫЙ СТЕКЛЯННЫЙ НИЖНИЙ ДОК ================= -->
        <nav class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-white/85 border border-slate-200/90 px-6 py-2.5 rounded-2xl backdrop-blur-xl shadow-[0_12px_40px_rgba(15,23,42,0.08)] flex items-center gap-8 z-50 max-w-[95%] sm:max-w-none transition-all duration-300">

            <!-- Квесты -->
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-700' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="12" cy="12" r="6"/>
                        <circle cx="12" cy="12" r="2"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-700' }}">Упражнения</span>
                <span class="w-1.5 h-1.5 rounded-full transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 shadow-[0_0_8px_rgba(79,70,229,0.5)]' : 'bg-transparent' }}"></span>
            </a>

            <!-- Модули -->
            <a href="{{ route('tools') }}"
                class="flex flex-col items-center gap-1 group transition-all duration-200">
                <div class="flex flex-col items-center transition-transform duration-200 group-hover:scale-105 {{ request()->routeIs('tools') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-700' }}">
                    <svg class="w-5 h-5 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="m5 7 5 5-5 5M12 17h8"/>
                    </svg>
                </div>
                <span class="text-[9px] font-extrabold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('tools') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-700' }}">Модули</span>
                <span class="w-1.5 h-1.5 rounded-full transition-all duration-300 {{ request()->routeIs('tools') ? 'bg-indigo-600 shadow-[0_0_8px_rgba(79,70,229,0.5)]' : 'bg-transparent' }}"></span>
            </a>

        </nav>
        <!-- =================================================================== -->
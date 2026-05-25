<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA & Mobile Standalone Mode Config -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Arise">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#020617">

    <!-- App Icons and Manifest -->
    <link rel="apple-touch-icon" href="/logo.svg">
    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <link rel="manifest" href="/manifest.json">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts (Подключаем Outfit для премиального вида) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        /* Премиальная стилизация полей ввода в темную тему */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background-color: #020617 !important;
            /* bg-slate-950 */
            border-color: #1e293b !important;
            /* border-slate-800 */
            color: #f1f5f9 !important;
            /* text-slate-100 */
            border-radius: 0.75rem !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1rem !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #6366f1 !important;
            /* focus:border-indigo-500 */
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15) !important;
        }

        /* Стилизация лейблов под игровой дашборд */
        label {
            color: #64748b !important;
            /* text-slate-500 */
            font-weight: 700 !important;
            font-size: 10px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }

        /* Кнопки сохранения (Primary) */
        button.inline-flex.items-center.bg-gray-800 {
            background-color: #4f46e5 !important;
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-gray-800:hover {
            background-color: #6366f1 !important;
            transform: translateY(-1px) !important;
        }

        /* Кнопки отмены (Secondary) */
        button.inline-flex.items-center.bg-white {
            background-color: #1e293b !important;
            /* bg-slate-800 */
            border-color: #334155 !important;
            /* border-slate-700 */
            color: #f1f5f9 !important;
            /* text-slate-100 */
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-white:hover {
            background-color: #334155 !important;
            /* bg-slate-700 */
            transform: translateY(-1px) !important;
        }

        /* Кнопки удаления (Danger) */
        button.inline-flex.items-center.bg-red-600 {
            background-color: #dc2626 !important;
            /* bg-red-600 */
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-red-600:hover {
            background-color: #ef4444 !important;
            /* bg-red-500 */
            transform: translateY(-1px) !important;
        }
    </style>
</head>

<body class="antialiased text-slate-100">
    <div class="min-h-screen bg-slate-950 relative">

        <!-- ================= ПРЕМИАЛЬНЫЙ СТЕКЛЯННЫЙ НИЖНИЙ ДОК ================= -->
        <nav class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-950/80 border border-slate-800/80 px-6 py-2.5 rounded-2xl backdrop-blur-xl shadow-2xl flex items-center gap-8 z-50 max-w-[95%] sm:max-w-none transition-all duration-300">

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
                <span class="w-1 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('terminal') ? 'bg-indigo-400 shadow-[0_0_8px_#818cf8]' : 'bg-transparent' }}"></span>
            </a>

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

        <!-- Page Content (Чистые, легкие отступы) -->
        <main class="pt-8 pb-28">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>
</body>

</html>

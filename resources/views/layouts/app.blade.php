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

        <!-- ================= УЛЬТРАМИНИМАЛИСТИЧНЫЙ НИЖНИЙ ДОК ================= -->
        <nav
            class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/60 border border-slate-800/80 px-4 sm:px-6 py-3.5 rounded-2xl backdrop-blur-md shadow-2xl flex items-center gap-4 sm:gap-6 z-50 max-w-[95%] sm:max-w-none">

            <!-- Квесты -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200' }}">
                <span class="text-sm">🎯</span>
                <span class="hidden sm:inline">Квесты</span>
            </a>

            <!-- Тренировки -->
            <a href="{{ route('workouts.index') }}"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('workouts.index') ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200' }}">
                <span class="text-sm">🏋️‍♂️</span>
                <span class="hidden sm:inline">Тренировки</span>
            </a>

            <!-- Кодекс -->
            <a href="{{ route('codex') }}"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('codex') ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200' }}">
                <span class="text-sm">📖</span>
                <span class="hidden sm:inline">Кодекс</span>
            </a>

            <!-- Инструменты -->
            <a href="{{ route('terminal') }}"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('terminal') ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200' }}">
                <span class="text-sm">🛠️</span>
                <span class="hidden sm:inline">Инструменты</span>
            </a>

            <!-- Профиль -->
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('profile.edit') ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200' }}">
                <span class="text-sm">👤</span>
                <span class="hidden sm:inline">Профиль</span>
            </a>

            <!-- Тонкий разделитель -->
            <div class="w-px h-4 bg-slate-800/80"></div>

            <!-- Выход -->
            <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-red-400 transition-colors duration-200 cursor-pointer">
                    <span class="text-sm">🚪</span>
                    <span class="hidden sm:inline">Выйти</span>
                </button>
            </form>
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

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

    <title>{{ $title ? $title : config("app.name") }}</title>

    <!-- Fonts (Подключаем Outfit для премиального вида) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #020617;
        }

        /* Премиальная стилизация скроллбара */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
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

<body class="antialiased text-slate-100 overflow-x-hidden">
    <div class="min-h-screen bg-slate-950 relative overflow-x-hidden">
        <!-- Деликатные фоновые эмбиент-свечения (ambient mesh glow) в фиксированном контейнере, чтобы не растягивать высоту страницы на смартфонах -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-10%] left-[-15%] w-[600px] h-[600px] rounded-full bg-indigo-600/8 blur-[130px]"></div>
            <div class="absolute bottom-[-10%] right-[-15%] w-[800px] h-[800px] rounded-full bg-emerald-600/4 blur-[160px]"></div>
        </div>
        <x-navigation></x-navigation>

        <!-- Global Toasts -->

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="fixed top-4 right-4 z-50 bg-rose-500/90 text-white px-6 py-4 rounded-xl shadow-lg border border-rose-400/50 backdrop-blur-md flex items-start gap-3 transition-all" x-transition>
                <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                <div class="text-sm font-bold tracking-wide">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button @click="show = false" class="ml-2 text-white/70 hover:text-white"><i class="fa-solid fa-times"></i></button>
            </div>
        @endif

        <!-- Global Top Bar -->
        <header class="relative z-10 {{ request()->routeIs('profile.edit') ? 'max-w-4xl' : 'max-w-2xl' }} mx-auto px-4 pt-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <img src="/logo.svg" class="w-6 h-6 transition-transform group-hover:scale-105" alt="Logo">
                <span class="text-xs font-black uppercase tracking-widest text-slate-300 group-hover:text-indigo-400 transition-colors">Arise</span>
            </a>
            
            @if(!request()->routeIs('profile.edit'))
            <a href="{{ route('profile.edit') }}" 
               class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 hover:border-indigo-500/30 text-slate-400 hover:text-indigo-400 flex items-center justify-center transition-colors cursor-pointer shadow-lg"
               title="Профиль">
                <svg class="w-4 h-4 stroke-current" fill="none" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </a>
            @endif
        </header>

        <!-- Page Content (Чистые, легкие отступы) -->
        <main class="pt-4 pb-28">
            {{ $slot }}
        </main>
    </div>
</body>

</html>

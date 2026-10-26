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
    <meta name="theme-color" content="#f7f8fa">

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
            background-color: #f7f8fa;
            color: #1e293b;
        }

        /* Премиальная стилизация скроллбара под мягкую светлую тему */
        ::-webkit-scrollbar {
            width: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f4f8;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Мягкая комфортная стилизация полей ввода (без режущего контраста) */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        textarea,
        select {
            background-color: #ffffff !important;
            border-color: #e2e6ed !important;
            color: #0f172a !important;
            border-radius: 0.75rem !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1rem !important;
            box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.03) !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        textarea:focus,
        select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12) !important;
        }

        /* Стилизация лейблов под аккуратный дашборд */
        label {
            color: #64748b !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }

        /* Кнопки сохранения (Primary) */
        button.inline-flex.items-center.bg-gray-800 {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2) !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-gray-800:hover {
            background-color: #6366f1 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25) !important;
        }

        /* Кнопки отмены (Secondary) */
        button.inline-flex.items-center.bg-white {
            background-color: #ffffff !important;
            border-color: #e2e6ed !important;
            color: #334155 !important;
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-white:hover {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
            transform: translateY(-1px) !important;
        }

        /* Кнопки удаления (Danger) */
        button.inline-flex.items-center.bg-red-600 {
            background-color: #fee2e2 !important;
            border-color: #fca5a5 !important;
            color: #dc2626 !important;
            border-radius: 0.75rem !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }

        button.inline-flex.items-center.bg-red-600:hover {
            background-color: #fecaca !important;
            color: #b91c1c !important;
            transform: translateY(-1px) !important;
        }
    </style>
</head>

<body class="antialiased text-slate-300 overflow-x-hidden bg-slate-950">
    <div class="min-h-screen bg-slate-950 relative overflow-x-hidden">
        <!-- Мягкие пастельные фоновые градиенты (не режут глаза, создают ощущение глубины и уюта) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-5%] left-[-10%] w-[600px] h-[600px] rounded-full bg-indigo-200/35 blur-[130px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[700px] h-[700px] rounded-full bg-emerald-100/40 blur-[160px]"></div>
            <div class="absolute top-[40%] right-[-12%] w-[500px] h-[500px] rounded-full bg-sky-100/35 blur-[140px]"></div>
        </div>
        <x-navigation></x-navigation>

        <!-- Global Toasts -->

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="fixed top-4 right-4 z-50 bg-rose-500 text-white px-6 py-4 rounded-xl shadow-xl border border-rose-400 backdrop-blur-md flex items-start gap-3 transition-all" x-transition>
                <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                <div class="text-sm font-bold tracking-wide">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button @click="show = false" class="ml-2 text-white/80 hover:text-white"><i class="fa-solid fa-times"></i></button>
            </div>
        @endif

        <!-- Global Top Bar -->
        <header class="relative z-10 {{ request()->routeIs('profile.edit') ? 'max-w-4xl' : 'max-w-2xl' }} mx-auto px-4 pt-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <img src="/logo.svg" class="w-6 h-6 transition-transform group-hover:scale-105" alt="Logo">
                <span class="text-xs font-black uppercase tracking-widest text-slate-300 group-hover:text-indigo-600 transition-colors">Arise</span>
            </a>
            
            @if(!request()->routeIs('profile.edit'))
            <a href="{{ route('profile.edit') }}" 
               class="w-9 h-9 rounded-xl bg-white border border-slate-200 hover:border-indigo-400 text-slate-500 hover:text-indigo-600 flex items-center justify-center transition-all cursor-pointer shadow-sm hover:shadow-md"
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

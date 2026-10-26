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

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts (Outfit для премиальной эстетики) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background-color: #f7f8fa;
                color: #1e293b;
            }
            /* Комфортная стилизация инпутов для светлой темы */
            input[type="text"], input[type="email"], input[type="password"] {
                background-color: #ffffff !important;
                border-color: #e2e6ed !important;
                color: #0f172a !important;
                border-radius: 0.75rem !important;
                font-size: 0.875rem !important;
                padding: 0.625rem 1rem !important;
                box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.03) !important;
            }
            input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
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
            /* Кнопки действий */
            button[type="submit"], .btn-primary {
                background-color: #4f46e5 !important;
                color: #ffffff !important;
                font-family: 'Outfit', sans-serif !important;
                font-weight: 700 !important;
                font-size: 11px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                border-radius: 0.75rem !important;
                padding: 0.625rem 1.25rem !important;
                transition: all 0.2s ease-in-out !important;
                box-shadow: 0 4px 14px rgba(79, 70, 229, 0.2) !important;
                cursor: pointer !important;
            }
            button[type="submit"]:hover {
                background-color: #6366f1 !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 6px 18px rgba(79, 70, 229, 0.25) !important;
            }
            /* Ссылки (Забыли пароль и др.) */
            a {
                color: #64748b !important;
                font-size: 11px !important;
                transition: color 0.2s ease !important;
            }
            a:hover {
                color: #4f46e5 !important;
            }
        </style>
    </head>
    <body class="antialiased text-slate-300 bg-slate-950 overflow-x-hidden relative">
        <!-- Мягкие пастельные фоновые сферы (уютное свечение без ослепления) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-5%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/35 blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-emerald-100/40 blur-[140px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div>
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-3xl font-black tracking-widest bg-gradient-to-r from-slate-900 to-indigo-600 bg-clip-text text-transparent group-hover:from-indigo-600 group-hover:to-violet-600 transition-colors duration-300">ARISE</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white/90 border border-slate-200/90 backdrop-blur-xl shadow-[0_20px_50px_rgba(15,23,42,0.06)] overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

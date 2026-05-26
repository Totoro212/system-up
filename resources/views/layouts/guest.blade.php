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

        <!-- Fonts (Outfit для премиальной эстетики) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            /* Премиальная стилизация инпутов под темную тему */
            input[type="text"], input[type="email"], input[type="password"] {
                background-color: #020617 !important; /* bg-slate-950 */
                border-color: #1e293b/80 !important; /* border-slate-800 */
                color: #f1f5f9 !important; /* text-slate-100 */
                border-radius: 0.75rem !important;
                font-size: 0.875rem !important;
                padding: 0.625rem 1rem !important;
            }
            input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
                border-color: #6366f1 !important; /* focus:border-indigo-500 */
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15) !important;
            }
            /* Стилизация лейблов под игровой дашборд */
            label {
                color: #64748b !important; /* text-slate-500 */
                font-weight: 700 !important;
                font-size: 10px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
            }
            /* Кнопки действий */
            button[type="submit"], .btn-primary {
                background-color: #4f46e5 !important; /* bg-indigo-600 */
                font-family: 'Outfit', sans-serif !important;
                font-weight: 700 !important;
                font-size: 11px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                border-radius: 0.75rem !important;
                padding: 0.625rem 1.25rem !important;
                transition: all 0.2s ease-in-out !important;
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15) !important;
                cursor: pointer !important;
            }
            button[type="submit"]:hover {
                background-color: #6366f1 !important; /* bg-indigo-500 */
                transform: translateY(-1px) !important;
            }
            /* Ссылки (Забыли пароль и др.) */
            a {
                color: #64748b !important;
                font-size: 11px !important;
                transition: color 0.2s ease !important;
            }
            a:hover {
                color: #f1f5f9 !important;
            }
        </style>
    </head>
    <body class="antialiased text-slate-100 bg-slate-950 overflow-x-hidden relative">
        <!-- Роскошные амбиентные неоновые сферы в фиксированном контейнере для гостевой страницы -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-10%] left-[-15%] w-[500px] h-[500px] rounded-full bg-indigo-600/8 blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-15%] w-[600px] h-[600px] rounded-full bg-emerald-600/4 blur-[140px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div>
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-3xl font-black tracking-widest bg-gradient-to-r from-slate-100 to-slate-400 bg-clip-text text-transparent group-hover:from-indigo-400 group-hover:to-violet-400 transition-colors duration-300">ARISE</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-slate-900/45 border border-slate-800/40 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.6)] overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

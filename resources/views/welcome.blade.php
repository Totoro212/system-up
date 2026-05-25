<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARISE — Простой трекер привычек и тренировок</title>

    <!-- Подключаем мягкий и современный шрифт Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen antialiased flex flex-col justify-between relative overflow-x-hidden">

    <!-- Мягкий фоновый градиент для создания уютной глубины (без резких неоновых вспышек) -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[500px] bg-gradient-to-b from-indigo-950/20 via-transparent to-transparent pointer-events-none"></div>

    <!-- Верхняя панель (Навигация) -->
    <header class="w-full max-w-5xl mx-auto px-6 py-6 flex justify-between items-center z-10">
        <!-- Логотип -->
        <a href="/" class="flex items-center gap-2 group">
            <span class="text-xl font-bold tracking-wider text-white">ARISE</span>
            <span class="text-[9px] bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 px-2 py-0.5 rounded-md font-semibold">TACKER</span>
        </a>
        
        <!-- Кнопки входа в шапке -->
        @if (Route::has('login'))
            <nav class="flex items-center gap-4 text-sm font-medium">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs tracking-wide uppercase transition-all shadow-md shadow-indigo-600/10">
                        Дашборд
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-colors text-xs font-semibold tracking-wider uppercase">
                        Войти
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-semibold tracking-wider uppercase transition-all">
                            Регистрация
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Основной контент (Hero + Уютный виджет) -->
    <main class="w-full max-w-4xl mx-auto px-6 flex-grow flex flex-col justify-center items-center py-12 z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">
            
            <!-- Левая часть: Лаконичное приветствие -->
            <div class="space-y-6 text-center md:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-300 text-[11px] font-semibold tracking-wide">
                    ✨ Твой день под контролем
                </span>
                
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Простой трекер привычек и тренировок
                </h1>
                
                <p class="text-base text-slate-400 leading-relaxed font-light">
                    ARISE помогает структурировать повседневные дела, закреплять полезные привычки и удобно просматривать тренировки. Всё самое важное — на одном экране и без лишней суеты.
                </p>

                <!-- Основные кнопки -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 justify-center md:justify-start">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/15 text-center">
                            Перейти в дашборд
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/15 text-center">
                                Создать аккаунт бесплатно
                            </a>
                            <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-300 font-semibold text-sm transition-all text-center">
                                У меня уже есть профиль
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/15 text-center">
                                Войти в систему
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Правая часть: Приятная, аккуратная карточка-превью -->
            <div class="flex justify-center md:justify-end">
                <div class="w-full max-w-[340px] bg-slate-900/40 border border-slate-900 rounded-2xl p-5 backdrop-blur-md shadow-xl relative overflow-hidden">
                    <!-- Заголовок карточки -->
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <span class="text-[9px] text-slate-500 uppercase tracking-widest font-bold">Сегодня</span>
                            <h3 class="text-base font-bold text-white tracking-wide">Мой день</h3>
                        </div>
                    </div>

                    <!-- Минималистичный список дел -->
                    <div class="space-y-3">
                        <!-- Пример 1 (Выполнено) -->
                        <div class="bg-slate-950/40 border border-emerald-500/10 rounded-xl p-3.5 flex justify-between items-center opacity-65">
                            <div class="flex items-center gap-3">
                                <span class="text-base">💧</span>
                                <span class="text-xs font-medium text-slate-400 line-through">Выпить 2 литра воды</span>
                            </div>
                            <span class="w-4 h-4 rounded-full bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-[10px] text-emerald-400">✓</span>
                        </div>

                        <!-- Пример 2 (Активно) -->
                        <div class="bg-slate-950/80 border border-slate-800/80 rounded-xl p-3.5 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="text-base">📖</span>
                                <span class="text-xs font-semibold text-slate-200">Чтение 20 страниц книги</span>
                            </div>
                            <span class="w-4 h-4 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-[9px] text-slate-400">+</span>
                        </div>

                        <!-- Пример 3 (Активно) -->
                        <div class="bg-slate-950/80 border border-slate-800/80 rounded-xl p-3.5 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="text-base">🧘</span>
                                <span class="text-xs font-semibold text-slate-200">Медитация 10 минут</span>
                            </div>
                            <span class="w-4 h-4 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-[9px] text-slate-400">+</span>
                        </div>
                    </div>

                    <!-- Нижняя строка статистики -->
                    <div class="mt-5 pt-4 border-t border-slate-950 flex justify-between text-[11px] text-slate-500 font-medium">
                        <span>🎯 Выполнено: 1 / 3</span>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Аккуратный минималистичный подвал -->
    <footer class="w-full text-center py-6 border-t border-slate-950 text-xs text-slate-600 z-10 max-w-5xl mx-auto px-6">
        <p>ARISE © 2026. Трекер для твоей дисциплины.</p>
    </footer>

</body>
</html>

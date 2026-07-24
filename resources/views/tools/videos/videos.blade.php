<!-- ================= ЭКРАН: ВИДЕОТЕКА ================= -->
<template x-if="currentTab === 'videos'">
    <div class="space-y-6" x-data="videoVault()">
        <!-- Навигационная панель назад -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-900/50">
            <button @click="currentTab = 'hub'"
                class="text-[10px] font-extrabold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest flex items-center gap-1.5 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-xl border border-slate-850/50 hover:-translate-y-0.5 transition-all">
                <span>←</span>
                <span>В Инструменты</span>
            </button>

            <!-- Кнопка Добавить видео -->
            <button @click="showAddModal = true"
                class="flex items-center gap-1.5 text-xs font-black text-white bg-indigo-600 hover:bg-indigo-500 px-3.5 py-2 rounded-xl transition-all duration-200 cursor-pointer shadow-lg shadow-indigo-950/40 hover:-translate-y-0.5">
                <span>+</span>
                <span>Добавить видео</span>
            </button>
        </div>

        <!-- Заголовок страницы -->
        <div class="flex justify-between items-end">
            <div>
                <x-h1>🎬 Видеотека</x-h1>
                <x-p class="text-slate-400 font-bold uppercase tracking-wider mt-1">Обучающие видео и видеоматериалы</x-p>
            </div>
        </div>

        <!-- Сетка видеокарточек -->
        <div class="space-y-4">
            <template x-if="videos.length === 0">
                <div class="text-center py-12 bg-slate-900/40 rounded-2xl border border-slate-900/60 text-slate-500 text-xs">
                    📹 Видео пока не добавлены. Нажмите «Добавить видео», чтобы сохранить ссылку.
                </div>
            </template>

            <div class="grid grid-cols-1 gap-4">
                <template x-for="(video, index) in videos" :key="video.id">
                    <x-card class="bg-slate-900 border-slate-850/80 shadow-2xl relative overflow-hidden space-y-3">
                        <!-- Шапка видео карточки -->
                        <div class="flex justify-between items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-100" x-text="video.title"></h3>
                            <button @click="deleteVideo(video.id)" class="text-slate-500 hover:text-red-400 text-xs p-1 transition-colors cursor-pointer" title="Удалить">
                                🗑️
                            </button>
                        </div>

                        <!-- Видеоплеер -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-800">
                            <!-- YouTube / Telegram Iframe -->
                            <template x-if="getEmbedUrl(video.url)">
                                <iframe :src="getEmbedUrl(video.url)" 
                                        class="w-full h-full border-0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            </template>

                            <!-- Чистый HTML5 Video Player (для Google Диска / MP4 / Cloudinary без перехода) -->
                            <template x-if="!getEmbedUrl(video.url)">
                                <video :src="getDirectVideoUrl(video.url)" controls class="w-full h-full object-contain bg-black">
                                    Ваш браузер не поддерживает данный видеоформат.
                                </video>
                            </template>
                        </div>
                    </x-card>
                </template>
            </div>
        </div>

        <!-- МОДАЛЬНОЕ ОКНО ДОБАВЛЕНИЯ ВИДЕО -->
        <div x-show="showAddModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
             style="display: none;">
            
            <div @click.away="showAddModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-5 space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-800/80 pb-3">
                    <h3 class="text-sm font-bold text-slate-100">➕ Добавить видео</h3>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-200 text-sm">✕</button>
                </div>

                <form @submit.prevent="addVideo()" class="space-y-3 text-xs">
                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold">Название видео</label>
                        <input type="text" x-model="newVideo.title" required placeholder="Например: Разбор техники приседаний"
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold">Ссылка на видео</label>
                        <input type="url" x-model="newVideo.url" required placeholder="https://www.youtube.com/watch?v=..."
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition-all">Отмена</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-950/40">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
function videoVault() {
    return {
        showAddModal: false,
        newVideo: {
            title: '',
            url: ''
        },
        videos: JSON.parse(localStorage.getItem('videoVaultList') || 'null') || [
            {
                id: 1,
                title: 'Основы инвестирования и личных финансов',
                url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            }
        ],

        init() {
            this.saveVideos();
        },

        getEmbedUrl(url) {
            if (!url) return null;
            
            // 1. YouTube regEx
            const ytMatch = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
            if (ytMatch && ytMatch[2].length === 11) {
                return 'https://www.youtube.com/embed/' + ytMatch[2] + '?rel=0&modestbranding=1&iv_load_policy=3&playsinline=1';
            }

            // 2. Telegram Embed
            const tgMatch = url.match(/https?:\/\/t\.me\/([a-zA-Z0-9_]+)\/(\d+)/);
            if (tgMatch && tgMatch[1] !== 'c') {
                return `https://t.me/${tgMatch[1]}/${tgMatch[2]}?embed=1`;
            }

            // 3. Google Drive Embed (надежный встроенный плеер)
            const driveMatch = url.match(/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/);
            if (driveMatch) {
                return `https://drive.google.com/file/d/${driveMatch[1]}/preview`;
            }
            
            return null; // MP4 / Cloudinary -> проигрывается в чистом HTML5 видеоплеере
        },

        getDirectVideoUrl(url) {
            return url;
        },

        addVideo() {
            if (!this.newVideo.title || !this.newVideo.url) return;

            this.videos.unshift({
                id: Date.now(),
                title: this.newVideo.title,
                url: this.newVideo.url
            });

            this.saveVideos();

            this.newVideo = { title: '', url: '' };
            this.showAddModal = false;
        },

        deleteVideo(id) {
            this.videos = this.videos.filter(v => v.id !== id);
            this.saveVideos();
        },

        saveVideos() {
            localStorage.setItem('videoVaultList', JSON.stringify(this.videos));
        }
    };
}
</script>

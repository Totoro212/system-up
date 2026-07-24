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

        <!-- Фильтр по категориям -->
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-none text-[11px] font-semibold">
            <template x-for="cat in categories" :key="cat">
                <button @click="selectedCategory = cat"
                    class="px-3 py-1.5 rounded-xl border transition-all whitespace-nowrap cursor-pointer"
                    :class="selectedCategory === cat 
                        ? 'bg-indigo-500/10 border-indigo-500/50 text-indigo-300 font-bold' 
                        : 'bg-slate-900/60 border-slate-800/80 text-slate-400 hover:text-slate-200'">
                    <span x-text="cat"></span>
                </button>
            </template>
        </div>

        <!-- Сетка видеокарточек -->
        <div class="space-y-4">
            <template x-if="filteredVideos.length === 0">
                <div class="text-center py-12 bg-slate-900/40 rounded-2xl border border-slate-900/60 text-slate-500 text-xs">
                    📹 Видео пока не добавлены. Нажмите «Добавить видео», чтобы сохранить ссылку или загрузить файл.
                </div>
            </template>

            <div class="grid grid-cols-1 gap-4">
                <template x-for="(video, index) in filteredVideos" :key="video.id">
                    <x-card class="bg-slate-900 border-slate-850/80 shadow-2xl relative overflow-hidden space-y-3">
                        <!-- Шапка видео карточки -->
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <span class="text-[9px] font-black text-indigo-400 uppercase tracking-wider px-2 py-0.5 bg-indigo-500/10 border border-indigo-500/20 rounded-md inline-block mb-1" x-text="video.category"></span>
                                <h3 class="text-sm font-bold text-slate-100" x-text="video.title"></h3>
                            </div>
                            <button @click="deleteVideo(video.id)" class="text-slate-500 hover:text-red-400 text-xs p-1 transition-colors cursor-pointer" title="Удалить">
                                🗑️
                            </button>
                        </div>

                        <!-- Видеоплеер -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-800">
                            <!-- YouTube Iframe -->
                            <template x-if="getEmbedUrl(video.url)">
                                <iframe :src="getEmbedUrl(video.url)" 
                                        class="w-full h-full border-0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            </template>

                            <!-- HTML5 Video Player (для файлов с ПК / mp4) -->
                            <template x-if="!getEmbedUrl(video.url)">
                                <video :src="video.url" controls class="w-full h-full object-contain bg-black">
                                    Ваш браузер не поддерживает данный видеоформат.
                                </video>
                            </template>
                        </div>

                        <!-- Описание / Заметка если есть -->
                        <template x-if="video.note">
                            <p class="text-xs text-slate-400 bg-slate-950/40 p-2.5 rounded-lg border border-slate-850/40" x-text="video.note"></p>
                        </template>
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

                <!-- Переключатель режима: Ссылка vs Файл с устройства -->
                <div class="grid grid-cols-2 gap-1 p-1 bg-slate-950 border border-slate-850 rounded-xl text-xs">
                    <button type="button" @click="sourceMode = 'link'" 
                            class="py-1.5 rounded-lg font-bold transition-all text-center"
                            :class="sourceMode === 'link' ? 'bg-indigo-600 text-white shadow' : 'text-slate-400 hover:text-slate-200'">
                        🔗 Ссылка (YouTube)
                    </button>
                    <button type="button" @click="sourceMode = 'file'" 
                            class="py-1.5 rounded-lg font-bold transition-all text-center"
                            :class="sourceMode === 'file' ? 'bg-indigo-600 text-white shadow' : 'text-slate-400 hover:text-slate-200'">
                        📁 Загрузить файл
                    </button>
                </div>

                <form @submit.prevent="addVideo()" class="space-y-3 text-xs">
                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold">Название видео</label>
                        <input type="text" x-model="newVideo.title" required placeholder="Например: Разбор техники приседаний"
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- Ввод Ссылки -->
                    <template x-if="sourceMode === 'link'">
                        <div>
                            <label class="block text-slate-400 mb-1 font-semibold">Ссылка на видео (YouTube / MP4)</label>
                            <input type="url" x-model="newVideo.url" :required="sourceMode === 'link'" placeholder="https://www.youtube.com/watch?v=..."
                                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
                        </div>
                    </template>

                    <!-- Выбор и Загрузка Файла с ПК -->
                    <template x-if="sourceMode === 'file'">
                        <div class="space-y-2">
                            <label class="block text-slate-400 font-semibold">Выбрать видеофайл с компьютера (.mp4, .webm, .mov)</label>
                            <input type="file" @change="uploadFile($event)" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                   class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 file:cursor-pointer">
                            
                            <template x-if="uploading">
                                <div class="flex items-center gap-2 text-indigo-400 font-bold text-xs py-1">
                                    <span class="animate-spin inline-block">🔄</span>
                                    <span>Загрузка на сервер...</span>
                                </div>
                            </template>

                            <template x-if="uploadError">
                                <p class="text-red-400 text-xs font-semibold" x-text="uploadError"></p>
                            </template>

                            <template x-if="newVideo.url && sourceMode === 'file' && !uploading">
                                <div class="text-emerald-400 text-xs font-semibold flex items-center gap-1">
                                    <span>✅</span> Файл готов к сохранению
                                </div>
                            </template>
                        </div>
                    </template>

                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold">Категория</label>
                        <select x-model="newVideo.category" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
                            <option value="Обучение">Обучение</option>
                            <option value="Зал">Зал / Тренировки</option>
                            <option value="Финансы">Финансы</option>
                            <option value="Мотивация">Мотивация</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold">Заметка (необязательно)</label>
                        <textarea x-model="newVideo.note" rows="2" placeholder="Краткие заметки к видео..."
                                  class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500 resize-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition-all">Отмена</button>
                        <button type="submit" :disabled="uploading || !newVideo.url" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-950/40 disabled:opacity-50">Сохранить</button>
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
        sourceMode: 'link', // 'link' или 'file'
        selectedCategory: 'Все',
        uploading: false,
        uploadError: null,
        categories: ['Все', 'Обучение', 'Зал', 'Финансы', 'Мотивация', 'Другое'],
        newVideo: {
            title: '',
            url: '',
            category: 'Обучение',
            note: ''
        },
        videos: JSON.parse(localStorage.getItem('videoVaultList') || 'null') || [
            {
                id: 1,
                title: 'Основы инвестирования и личных финансов',
                url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                category: 'Финансы',
                note: 'Базовый разбор управления личным капиталом.'
            }
        ],

        init() {
            this.saveVideos();
        },

        get filteredVideos() {
            if (this.selectedCategory === 'Все') {
                return this.videos;
            }
            return this.videos.filter(v => v.category === this.selectedCategory);
        },

        getEmbedUrl(url) {
            if (!url) return null;
            
            // 1. YouTube regEx
            const ytMatch = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
            if (ytMatch && ytMatch[2].length === 11) {
                return 'https://www.youtube.com/embed/' + ytMatch[2] + '?rel=0&modestbranding=1';
            }

            // 2. Telegram Embed (например https://t.me/my_channel/42)
            const tgMatch = url.match(/https?:\/\/t\.me\/([a-zA-Z0-9_]+)\/(\d+)/);
            if (tgMatch) {
                return `https://t.me/${tgMatch[1]}/${tgMatch[2]}?embed=1`;
            }
            
            return null; // Прямая ссылка на mp4 / загруженный файл
        },

        async uploadFile(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploading = true;
            this.uploadError = null;

            const formData = new FormData();
            formData.append('video', file);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route("tools.videos.upload") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.newVideo.url = data.url;
                    if (!this.newVideo.title) {
                        this.newVideo.title = file.name.replace(/\.[^/.]+$/, "");
                    }
                } else {
                    this.uploadError = data.message || 'Ошибка загрузки файла на сервер (максимум 100 МБ).';
                }
            } catch (err) {
                this.uploadError = 'Сетевая ошибка при загрузке видео.';
            } finally {
                this.uploading = false;
            }
        },

        addVideo() {
            if (!this.newVideo.title || !this.newVideo.url) return;

            this.videos.unshift({
                id: Date.now(),
                title: this.newVideo.title,
                url: this.newVideo.url,
                category: this.newVideo.category,
                note: this.newVideo.note
            });

            this.saveVideos();

            this.newVideo = { title: '', url: '', category: 'Обучение', note: '' };
            this.showAddModal = false;
            this.sourceMode = 'link';
            this.uploadError = null;
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

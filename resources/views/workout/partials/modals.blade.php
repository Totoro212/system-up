        <!-- ================= МОДАЛЬНОЕ ОКНО СОЗДАНИЯ С ДИНАМИЧЕСКИМ ФОРМИРОВАНИЕМ НА ALPINE ================= -->
        <x-modal name="create-workout" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6" x-data="{
                exercises: [
                    { title: '', sets: 3, reps: '10-12', weight: '' }
                ],
                addExercise() {
                    this.exercises.push({ title: '', sets: 3, reps: '10-12', weight: '' });
                },
                removeExercise(index) {
                    if (this.exercises.length > 1) {
                        this.exercises.splice(index, 1);
                    }
                }
            }">

                <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                    Создать программу
                </x-h2>

                <form method="POST" action="{{ route('workouts.store') }}" class="space-y-4">
                    @csrf

                    <!-- Название тренировки -->
                    <div>
                        <x-input-label for="workout_title" value="Название программы" />
                        <x-text-input type="text" name="title" id="workout_title" required placeholder="Например: Силовая А, Сплит: Грудь/Спина" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Динамический блок упражнений -->
                    <div class="space-y-4 border-t border-slate-850 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">Упражнения в
                                тренировке</span>
                            <button type="button" x-on:click="addExercise()"
                                class="text-xs font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider cursor-pointer">
                                ➕ Добавить упражнение
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                            <template x-for="(exercise, index) in exercises" :key="index">
                                <div
                                    class="bg-slate-950/80 border border-slate-850 p-4 rounded-2xl relative space-y-3">

                                    <!-- Кнопка удаления упражнения -->
                                    <button type="button" x-show="exercises.length > 1"
                                        x-on:click="removeExercise(index)"
                                        class="absolute top-2.5 right-2.5 w-6 h-6 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors cursor-pointer text-xs">
                                        ✕
                                    </button>

                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest"
                                        x-text="'Упражнение #' + (index + 1)"></div>

                                    <!-- Название -->
                                    <div>
                                        <input type="text" :name="'exercises[' + index + '][title]'" required
                                            placeholder="Название (например: Жим штанги лежа)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    <!-- Подходы, Повторы, Вес -->
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <input type="text" inputmode="numeric" pattern="[0-9]*" :name="'exercises[' + index + '][sets]'" required
                                                placeholder="Подходы (например: 4)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][reps]'" required
                                                placeholder="Повторы (например: 12)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][weight]'"
                                                placeholder="Вес (например: 50 кг)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Кнопки управления -->
                    <div class="flex justify-end gap-3 pt-2.5 border-t border-slate-850">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <x-primary-button>
                            Сохранить план
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>

        <!-- ================= МОДАЛЬНОЕ ОКНО РЕДАКТИРОВАНИЯ С ALPINE ================= -->
        <x-modal name="edit-workout" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6" x-data="{
                id: null,
                title: '',
                exercises: []
            }"
            x-on:open-edit-workout-modal.window="
                id = $event.detail.id;
                title = $event.detail.title;
                exercises = $event.detail.exercises.map(ex => ({
                    id: ex.id,
                    title: ex.title,
                    sets: ex.sets,
                    reps: ex.reps,
                    weight: ex.weight || ''
                }));
                $dispatch('open-modal', 'edit-workout');
            ">

                <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                    Редактировать программу
                </x-h2>

                <form method="POST" :action="'{{ url('workouts') }}/' + id" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <!-- Название тренировки -->
                    <div>
                        <x-input-label for="edit_workout_title" value="Название программы" />
                        <x-text-input type="text" name="title" id="edit_workout_title" x-model="title" required placeholder="Например: Силовая А, Сплит: Грудь/Спина" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Динамический блок упражнений -->
                    <div class="space-y-4 border-t border-slate-850 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">Упражнения в
                                тренировке</span>
                            <button type="button" x-on:click="exercises.push({ id: null, title: '', sets: 3, reps: '10-12', weight: '' })"
                                class="text-xs font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider cursor-pointer">
                                ➕ Добавить упражнение
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                            <template x-for="(exercise, index) in exercises" :key="index">
                                <div
                                    class="bg-slate-950/80 border border-slate-850 p-4 rounded-2xl relative space-y-3">

                                    <!-- Передача ID существующего упражнения, если есть -->
                                    <input type="hidden" :name="'exercises[' + index + '][id]'" x-model="exercise.id">

                                    <!-- Кнопка удаления упражнения -->
                                    <button type="button" x-show="exercises.length > 1"
                                        x-on:click="exercises.splice(index, 1)"
                                        class="absolute top-2.5 right-2.5 w-6 h-6 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors cursor-pointer text-xs">
                                        ✕
                                    </button>

                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest"
                                        x-text="'Упражнение #' + (index + 1)"></div>

                                    <!-- Название -->
                                    <div>
                                        <input type="text" :name="'exercises[' + index + '][title]'" x-model="exercise.title" required
                                            placeholder="Название (например: Жим штанги лежа)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    <!-- Подходы, Повторы, Вес -->
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <input type="text" inputmode="numeric" pattern="[0-9]*" :name="'exercises[' + index + '][sets]'" x-model="exercise.sets" required
                                                placeholder="Подходы (например: 4)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][reps]'" x-model="exercise.reps" required
                                                placeholder="Повторы (например: 12)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][weight]'" x-model="exercise.weight"
                                                placeholder="Вес (например: 50 кг)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Кнопки управления -->
                    <div class="flex justify-end gap-3 pt-2.5 border-t border-slate-850">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <x-primary-button>
                            Сохранить изменения
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>

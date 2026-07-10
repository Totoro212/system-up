<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\ExerciseLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    /**
     * Отобразить список тренировок и определить следующую в очереди.
     *
     * Логика очереди (round-robin):
     * Все тренировки пользователя отсортированы по sort_order.
     * Следующая тренировка — та, у которой last_performed_at самая старая
     * (или NULL, если ещё не выполнялась). При равенстве — приоритет по sort_order.
     * Если текущая «следующая» тренировка уже выполнена сегодня — значит день отдыха.
     */
    public function index(): View
    {
        $workouts = Workout::with('exercises')
            ->where('user_id', auth()->id())
            ->ordered()
            ->get();

        // Все тренировки участвуют в ротации программы
        $programWorkouts = $workouts;

        // Определяем следующую тренировку в очереди (round-robin) ТОЛЬКО среди программных:
        // Приоритет: сначала те, что никогда не выполнялись (NULL),
        // затем те, что выполнялись давно, при равенстве — по sort_order.
        $nextWorkout = $programWorkouts
            ->sortBy(function ($workout) {
                $timestamp = $workout->last_performed_at
                    ? $workout->last_performed_at->timestamp
                    : 0;
                return $timestamp + ($workout->sort_order / 10000);
            })
            ->first();

        // Если следующая тренировка уже выполнена сегодня — показываем день отдыха
        $todayWorkout = null;
        if ($nextWorkout && !($nextWorkout->last_performed_at && $nextWorkout->last_performed_at->isToday())) {
            $todayWorkout = $nextWorkout;
        }

        // Рассчитываем статусы отставания для каждой тренировки
        foreach ($workouts as $workout) {
            if (!$workout->last_performed_at) {
                $workout->status = 'not_started';
                $workout->status_label = 'Не начато';
                $workout->status_color = 'text-slate-400 bg-slate-500/10 border-slate-500/20';
            } else {
                $daysSince = now()->diffInDays($workout->last_performed_at);
                if ($daysSince < 7) {
                    $workout->status = 'in_tone';
                    $workout->status_label = 'В тонусе';
                    $workout->status_color = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                } elseif ($daysSince <= 10) {
                    $workout->status = 'warning';
                    $workout->status_label = 'Пропуск';
                    $workout->status_color = 'text-amber-400 bg-amber-500/10 border-amber-500/20';
                } else {
                    $workout->status = 'lagging';
                    $workout->status_label = 'Отстает! 🔥';
                    $workout->status_color = 'text-red-400 bg-red-500/10 border-red-500/20';
                }
            }
        }

        $totalProgramWorkouts = $programWorkouts->count();

        return view('workout.index', compact('programWorkouts', 'todayWorkout', 'totalProgramWorkouts'));
    }

    /**
     * Сохранить тренировку и все её упражнения одной безопасной транзакцией.
     * sort_order назначается автоматически (следующий в очереди).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'in_rotation' => ['nullable', 'boolean'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.title' => ['required', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string', 'max:255'],
            'exercises.*.target_muscles' => ['nullable', 'string', 'max:255'],
            'exercises.*.weight' => ['nullable', 'string', 'max:255'],
            'exercises.*.description' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($validated) {
            // sort_order назначается автоматически
            $maxOrder = auth()->user()->workouts()->max('sort_order') ?? -1;

            $workout = auth()->user()->workouts()->create([
                'title' => $validated['title'],
                'sort_order' => $maxOrder + 1,
                'in_rotation' => true,
            ]);

            foreach ($validated['exercises'] as $exerciseData) {
                $workout->exercises()->create($exerciseData);
            }
        });

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно создана!');
    }

    /**
     * Обновить тренировку и её упражнения безопасной транзакцией.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.id' => ['nullable', 'integer'],
            'exercises.*.title' => ['required', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string', 'max:255'],
            'exercises.*.weight' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $workout) {
            $workout->update([
                'title' => $validated['title'],
            ]);

            $existingExerciseIds = [];
            foreach ($validated['exercises'] as $exerciseData) {
                if (!empty($exerciseData['id'])) {
                    $exercise = $workout->exercises()->findOrFail($exerciseData['id']);
                    $exercise->update($exerciseData);
                    $existingExerciseIds[] = $exercise->id;
                } else {
                    $newExercise = $workout->exercises()->create($exerciseData);
                    $existingExerciseIds[] = $newExercise->id;
                }
            }

            // Удаляем упражнения, которые больше не присутствуют в обновленном списке
            $workout->exercises()->whereNotIn('id', $existingExerciseIds)->delete();
        });

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно обновлена!');
    }

    /**
     * Отметить тренировку как выполненную сегодня.
     */
    public function complete(Request $request, $id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);

        $workout->update(['last_performed_at' => now()]);

        return redirect()->route('workouts.index')->with('success', 'Отлично! Тренировка выполнена! 💪');
    }

    /**
     * Удалить программу тренировки со всеми её упражнениями.
     */
    public function destroy($id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);
        $workout->delete();

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно удалена.');
    }

    /**
     * Загрузить основную программу тренировок (PULL/PUSH/LEGS) по умолчанию для текущего пользователя.
     * Тренировки идут последовательно: PULL → PUSH → LEGS.
     */
    public function seedDefault(): RedirectResponse
    {
        $user = auth()->user();

        DB::transaction(function () use ($user) {
            // Очищаем старые тренировки пользователя, чтобы избежать дублирования
            Workout::where('user_id', $user->id)->delete();

            // 1. PULL (sort_order: 0)
            $pull = Workout::create([
                'user_id' => $user->id,
                'title' => 'PULL — Спина, Бицепс, Задняя дельта',
                'sort_order' => 0,
            ]);

            $pull->exercises()->createMany([
                [
                    'title' => 'Подтягивания + Негативные (Улица)',
                    'sets' => 4,
                    'reps' => 'до отказа',
                    'target_muscles' => 'спина, бицепс, задняя дельта',
                    'weight' => 'Свой вес',
                    'description' => "• Выполняйте обычные подтягивания до отказа\n• Сразу после этого сделайте медленные негативные опускания (с прыжка вверх, медленно вниз)",
                ],
                [
                    'title' => 'Тяга гантели одной рукой',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'широчайшие, круглая мышца спины, бицепс',
                    'weight' => '12 кг',
                    'description' => "• Тяга гантели к бедру в наклоне с упором на колено и руку\n• Не тяните гантель к груди\n• Сводите лопатку в верхней точке",
                ],
                [
                    'title' => 'Тяга двух гантелей в наклоне',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'широчайшие, ромбовидные, задняя дельта',
                    'weight' => '10 кг',
                    'description' => "• Спина прямая, наклон корпуса вперед\n• Тяните обе гантели одновременно к поясу\n• Задерживайтесь в пиковом сокращении на 1 сек",
                ],
                [
                    'title' => 'Махи гантелей в наклоне',
                    'sets' => 4,
                    'reps' => '15',
                    'target_muscles' => 'задняя дельта',
                    'weight' => '5 кг',
                    'description' => "• Наклон корпуса вперед, локти слегка согнуты\n• Разводите гантели в стороны за счет силы задних дельт\n• Медленно опускайте вес вниз",
                ],
                [
                    'title' => 'Подъем на бицепс с супинацией',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'бицепс',
                    'weight' => '7 кг',
                    'description' => "• Сгибайте руки с гантелями стоя\n• Разворачивайте кисти наружу (супинация) в верхней половине амплитуды",
                ],
                [
                    'title' => 'Сгибания "Молот"',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'брахиалис, плечелучевая мышца',
                    'weight' => '7 кг',
                    'description' => "• Подъем гантелей нейтральным хватом (ладони смотрят друг на друга)\n• Держите локти прижатыми к телу",
                ],
                [
                    'title' => 'L-разводки (Наружная ротация)',
                    'sets' => 2,
                    'reps' => '15',
                    'target_muscles' => 'вращательная манжета плеча',
                    'weight' => '3 кг',
                    'description' => "• Локти согнуты под 90 градусов и прижаты к бокам\n• Отводите предплечья наружу, укрепляя плечевой сустав",
                ],
            ]);

            // 2. PUSH (sort_order: 1)
            $push = Workout::create([
                'user_id' => $user->id,
                'title' => 'PUSH — Плечи, Грудь, Трицепс, Пресс',
                'sort_order' => 1,
            ]);

            $push->exercises()->createMany([
                [
                    'title' => 'Глубокие отжимания от пола на гантелях',
                    'sets' => 4,
                    'reps' => '15',
                    'target_muscles' => 'грудь, трицепс, передняя дельта',
                    'weight' => 'Свой вес',
                    'description' => "• Руки на гантелях для увеличения амплитуды\n• Опускайтесь глубже, хорошо растягивая грудные мышцы\n• Тело держите прямой линией",
                ],
                [
                    'title' => 'Жим гантелей сидя вверх',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'передняя дельта, средняя дельта, трицепс',
                    'weight' => '10 кг',
                    'description' => "• Жим гантелей над головой сидя на скамье/стуле с прямой спиной\n• Не сводите локти сильно вперед, контролируйте опускание",
                ],
                [
                    'title' => 'Махи гантелей в стороны стоя',
                    'sets' => 5,
                    'reps' => '15',
                    'target_muscles' => 'средняя дельта',
                    'weight' => '5 кг',
                    'description' => "• Подъемы рук с гантелями в стороны до уровня плеч\n• Локти слегка согнуты, мизинец чуть выше большого пальца\n• Главный фокус на ширину плеч и V-силуэт",
                ],
                [
                    'title' => 'Жим гантелей лежа на полу (Floor Press)',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'грудь, трицепс',
                    'weight' => '12 кг',
                    'description' => "• Лежа спиной на полу, выжимайте гантели вверх\n• В нижней точке касайтесь пола трицепсом, но не расслабляйтесь",
                ],
                [
                    'title' => 'Французский жим',
                    'sets' => 3,
                    'reps' => '12',
                    'target_muscles' => 'трицепс (длинная головка)',
                    'weight' => '7 кг',
                    'description' => "• Французский жим с гантелями лежа на полу или скамье\n• Локти смотрят вверх и остаются неподвижными",
                ],
                [
                    'title' => 'Обратные скручивания лежа',
                    'sets' => 4,
                    'reps' => '20',
                    'target_muscles' => 'пресс (нижний отдел)',
                    'weight' => 'Свой вес',
                    'description' => "• Лежа на спине, руки вдоль тела\n• Подтягивайте колени к груди, приподнимая таз над полом",
                ],
            ]);

            // 3. LEGS (sort_order: 2)
            $legs = Workout::create([
                'user_id' => $user->id,
                'title' => 'LEGS — Ноги, Ягодицы, Икры',
                'sort_order' => 2,
            ]);

            $legs->exercises()->createMany([
                [
                    'title' => 'Ягодичный мостик',
                    'sets' => 2,
                    'reps' => '20',
                    'target_muscles' => 'ягодицы, задняя поверхность бедра',
                    'weight' => '10 кг',
                    'description' => "• Лёжа на спине, ноги согнуты в коленях\n• Поднимайте таз вверх до прямой линии с телом, сжимая ягодицы вверху\n• Можно положить гантель на бедра для дополнительного веса",
                ],
                [
                    'title' => 'Болгарские сплит-приседания',
                    'sets' => 4,
                    'reps' => '10 /ногу',
                    'target_muscles' => 'квадрицепсы, ягодицы, баланс',
                    'weight' => '7 кг',
                    'description' => "• Задняя нога на скамье или стуле\n• Опускайтесь плавно, сохраняя упор на пятку передней ноги",
                ],
                [
                    'title' => 'Румынская тяга',
                    'sets' => 4,
                    'reps' => '12',
                    'target_muscles' => 'задняя поверхность бедра, ягодицы, разгибатели спины',
                    'weight' => '12 кг',
                    'description' => "• Отводите таз назад, наклоняясь вперед\n• Держите спину строго прямой, гантели скользят вдоль ног",
                ],
                [
                    'title' => 'Негативные скандинавские сгибания',
                    'sets' => 3,
                    'reps' => '8',
                    'target_muscles' => 'задняя поверхность бедра',
                    'weight' => 'Свой вес',
                    'description' => "• Стоя на коленях, закрепите стопы под тяжелым упором\n• Медленно опускайте корпус вперед, сопротивляясь силе тяжести\n• Оттолкнитесь руками от пола для возврата в исходное положение",
                ],
                [
                    'title' => 'Кубковые приседания',
                    'sets' => 3,
                    'reps' => '15',
                    'target_muscles' => 'квадрицепсы, ягодицы',
                    'weight' => '12 кг',
                    'description' => "• Приседания с удержанием гантели перед грудью vertical-хват\n• Держите спину прямой, колени разводите в стороны носков",
                ],
                [
                    'title' => 'Подъемы на носок стоя',
                    'sets' => 3,
                    'reps' => '20',
                    'target_muscles' => 'икроножные',
                    'weight' => '10 кг',
                    'description' => "• Выполняйте подъемы на одной ноге для максимальной нагрузки\n• Растягивайте икру в нижней точке и делайте пиковое сокращение вверху",
                ],
                [
                    'title' => 'Подъемы на носки сидя',
                    'sets' => 3,
                    'reps' => '20',
                    'target_muscles' => 'камбаловидная мышца',
                    'weight' => '10 кг',
                    'description' => "• Выполняйте подъемы на носки сидя с гантелями на коленях\n• Фокус на медленный темп и максимальное сокращение",
                ],
            ]);
        });

        return redirect()->route('workouts.index')->with('success', 'Основная программа тренировок PULL/PUSH/LEGS успешно установлена!');
    }
}

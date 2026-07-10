<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: пользователь может успешно просматривать список тренировок.
     */
    public function test_user_can_view_workouts_page(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('workouts.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Вне программы');
    }

    /**
     * Тест: пользователь может успешно создать тренировку, и она автоматически в ротации.
     */
    public function test_user_can_create_workout(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('workouts.store'), [
                'title' => 'Test Workout',
                'exercises' => [
                    [
                        'title' => 'Test Exercise',
                        'sets' => 3,
                        'reps' => '10',
                        'target_muscles' => 'Chest',
                        'weight' => '50 кг',
                        'description' => 'Test description',
                    ]
                ]
            ]);

        $response->assertRedirect(route('workouts.index'));
        $response->assertSessionHas('success', 'Программа тренировки успешно создана!');

        $this->assertDatabaseHas('workouts', [
            'user_id' => $user->id,
            'title' => 'Test Workout',
            'in_rotation' => true,
        ]);
    }

    /**
     * Тест: пользователь может удалить свою тренировку.
     */
    public function test_user_can_delete_workout(): void
    {
        $user = User::factory()->create();
        $workout = Workout::create([
            'user_id' => $user->id,
            'title' => 'Workout to Delete',
            'sort_order' => 1,
            'in_rotation' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('workouts.destroy', $workout->id));

        $response->assertRedirect(route('workouts.index'));
        $response->assertSessionHas('success', 'Программа тренировки успешно удалена.');

        $this->assertDatabaseMissing('workouts', [
            'id' => $workout->id,
        ]);
    }

    /**
     * Тест: пользователь может обновить тренировку.
     */
    public function test_user_can_update_workout(): void
    {
        $user = User::factory()->create();
        $workout = Workout::create([
            'user_id' => $user->id,
            'title' => 'Initial Workout',
            'sort_order' => 1,
            'in_rotation' => true,
        ]);
        $exercise = $workout->exercises()->create([
            'title' => 'Initial Exercise',
            'sets' => 3,
            'reps' => '10',
            'weight' => '50 кг',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('workouts.update', $workout->id), [
                'title' => 'Updated Workout Title',
                'exercises' => [
                    [
                        'id' => $exercise->id,
                        'title' => 'Updated Exercise Title',
                        'sets' => 4,
                        'reps' => '12',
                        'weight' => '60 кг',
                    ],
                    [
                        'id' => null, // новое упражнение
                        'title' => 'New Added Exercise',
                        'sets' => 3,
                        'reps' => '15',
                        'weight' => '20 кг',
                    ]
                ]
            ]);

        $response->assertRedirect(route('workouts.index'));
        $response->assertSessionHas('success', 'Программа тренировки успешно обновлена!');

        $this->assertDatabaseHas('workouts', [
            'id' => $workout->id,
            'title' => 'Updated Workout Title',
        ]);

        $this->assertDatabaseHas('exercises', [
            'id' => $exercise->id,
            'title' => 'Updated Exercise Title',
            'sets' => 4,
            'reps' => '12',
            'weight' => '60 кг',
        ]);

        $this->assertDatabaseHas('exercises', [
            'workout_id' => $workout->id,
            'title' => 'New Added Exercise',
            'sets' => 3,
            'reps' => '15',
            'weight' => '20 кг',
        ]);
    }

    /**
     * Тест: пользователь не может обновить чужую тренировку.
     */
    public function test_user_cannot_update_others_workout(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $workout = Workout::create([
            'user_id' => $user1->id,
            'title' => 'User 1 Workout',
            'sort_order' => 1,
            'in_rotation' => true,
        ]);

        $response = $this
            ->actingAs($user2)
            ->patch(route('workouts.update', $workout->id), [
                'title' => 'Hacked title',
                'exercises' => [
                    [
                        'title' => 'Hacked exercise',
                        'sets' => 3,
                        'reps' => '10',
                    ]
                ]
            ]);

        $response->assertStatus(404);
    }

    /**
     * Тест: удаление упражнения при редактировании тренировки.
     */
    public function test_updating_workout_deletes_removed_exercises(): void
    {
        $user = User::factory()->create();
        $workout = Workout::create([
            'user_id' => $user->id,
            'title' => 'Initial Workout',
            'sort_order' => 1,
            'in_rotation' => true,
        ]);
        $exercise1 = $workout->exercises()->create([
            'title' => 'Exercise 1',
            'sets' => 3,
            'reps' => '10',
        ]);
        $exercise2 = $workout->exercises()->create([
            'title' => 'Exercise 2',
            'sets' => 4,
            'reps' => '12',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('workouts.update', $workout->id), [
                'title' => 'Workout with only Exercise 1',
                'exercises' => [
                    [
                        'id' => $exercise1->id,
                        'title' => 'Exercise 1',
                        'sets' => 3,
                        'reps' => '10',
                    ]
                ]
            ]);

        $response->assertRedirect(route('workouts.index'));

        $this->assertDatabaseHas('exercises', [
            'id' => $exercise1->id,
        ]);

        $this->assertDatabaseMissing('exercises', [
            'id' => $exercise2->id,
        ]);
    }

    /**
     * Тест: пользователь может загрузить программу по умолчанию.
     */
    public function test_user_can_seed_default_workouts(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('workouts.seed_default'));

        $response->assertRedirect(route('workouts.index'));
        $response->assertSessionHas('success', 'Основная программа тренировок PULL/PUSH/LEGS успешно установлена!');

        // Проверяем создание 3-х тренировок
        $this->assertDatabaseHas('workouts', [
            'user_id' => $user->id,
            'title' => 'PULL — Спина, Бицепс, Задняя дельта',
            'sort_order' => 0,
        ]);

        $this->assertDatabaseHas('workouts', [
            'user_id' => $user->id,
            'title' => 'PUSH — Плечи, Грудь, Трицепс, Пресс',
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('workouts', [
            'user_id' => $user->id,
            'title' => 'LEGS — Ноги, Ягодицы, Икры',
            'sort_order' => 2,
        ]);

        // Убедимся, что старый TONUS или старый формат больше не создается
        $this->assertDatabaseMissing('workouts', [
            'user_id' => $user->id,
            'title' => 'ТОНУС — всё тело (турник + брусья)',
        ]);
    }

    /**
     * Тест: пользователь может выполнить тренировку без указания весов.
     */
    public function test_user_can_complete_workout_without_weights(): void
    {
        $user = User::factory()->create();
        $workout = Workout::create([
            'user_id' => $user->id,
            'title' => 'Test Workout',
            'sort_order' => 1,
            'in_rotation' => true,
        ]);
        $exercise = $workout->exercises()->create([
            'title' => 'Test Exercise',
            'sets' => 3,
            'reps' => '10',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('workouts.complete', $workout->id));

        $response->assertRedirect(route('workouts.index'));
        $response->assertSessionHas('success', 'Отлично! Тренировка выполнена! 💪');

        $workout->refresh();
        $this->assertNotNull($workout->last_performed_at);

        // Убедимся, что записи логов весов не были созданы
        $this->assertDatabaseEmpty('exercise_logs');
    }
}

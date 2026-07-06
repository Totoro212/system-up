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
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: на странице квестов отображается кнопка Тренировка и модальное окно.
     */
    public function test_dashboard_displays_today_workout(): void
    {
        $user = User::factory()->create();

        // 1. Сначала без тренировок (должен быть день отдыха)
        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('тренировка');
        $response->assertSee('Сегодня день отдыха');

        // 2. Добавляем тренировку
        $workout = Workout::create([
            'user_id' => $user->id,
            'title' => 'Test Chest Workout',
            'sort_order' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Test Chest Workout');

        // 3. Выполняем тренировку с дашборда
        $response = $this
            ->actingAs($user)
            ->from(route('dashboard'))
            ->post(route('workouts.complete', $workout->id));

        $response->assertRedirect(route('dashboard'));
        
        $this->assertDatabaseHas('workouts', [
            'id' => $workout->id,
        ]);
        $this->assertNotNull($workout->fresh()->last_performed_at);
    }
}

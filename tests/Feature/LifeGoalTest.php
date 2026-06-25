<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LifeGoal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LifeGoalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: пользователь может успешно создать жизненную цель.
     */
    public function test_user_can_create_life_goal(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.store'), [
                'title' => 'Learn Spanish',
                'description' => 'Spend 15 mins daily on Duolingo',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Жизненная цель успешно добавлена!');

        $this->assertDatabaseHas('life_goals', [
            'user_id' => $user->id,
            'title' => 'Learn Spanish',
            'description' => 'Spend 15 mins daily on Duolingo',
            'is_completed' => false,
        ]);
    }

    /**
     * Тест: пользователь может переключать статус своей жизненной цели.
     */
    public function test_user_can_toggle_their_own_life_goal_completion(): void
    {
        $user = User::factory()->create();
        $goal = LifeGoal::create([
            'user_id' => $user->id,
            'title' => 'Run Marathon',
            'description' => 'Under 4 hours',
            'is_completed' => false,
        ]);

        // Отмечаем как выполненную
        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.toggle', $goal->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Цель отмечена как выполненная! 🎉');

        $goal->refresh();
        $this->assertTrue($goal->is_completed);
        $this->assertNotNull($goal->completed_at);

        // Отмечаем как невыполненную (активную)
        $response = $this
            ->actingAs($user)
            ->post(route('life-goals.toggle', $goal->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Цель снова активна.');

        $goal->refresh();
        $this->assertFalse($goal->is_completed);
        $this->assertNull($goal->completed_at);
    }

    /**
     * Тест: пользователь не может переключить чужую жизненную цель.
     */
    public function test_user_cannot_toggle_other_users_life_goal_completion(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $goal = LifeGoal::create([
            'user_id' => $user2->id,
            'title' => 'Secret Mission',
            'is_completed' => false,
        ]);

        $response = $this
            ->actingAs($user1)
            ->post(route('life-goals.toggle', $goal->id));

        $response->assertStatus(404);

        $goal->refresh();
        $this->assertFalse($goal->is_completed);
    }

    /**
     * Тест: пользователь может успешно удалить свою жизненную цель.
     */
    public function test_user_can_delete_their_own_life_goal(): void
    {
        $user = User::factory()->create();
        $goal = LifeGoal::create([
            'user_id' => $user->id,
            'title' => 'Read War and Peace',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('life-goals.destroy', $goal->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Жизненная цель успешно удалена!');

        $this->assertDatabaseMissing('life_goals', [
            'id' => $goal->id,
        ]);
    }

    /**
     * Тест: пользователь не может удалить чужую жизненную цель.
     */
    public function test_user_cannot_delete_other_users_life_goal(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $goal = LifeGoal::create([
            'user_id' => $user2->id,
            'title' => 'Important Document',
        ]);

        $response = $this
            ->actingAs($user1)
            ->delete(route('life-goals.destroy', $goal->id));

        $response->assertStatus(404);

        $this->assertDatabaseHas('life_goals', [
            'id' => $goal->id,
        ]);
    }
}

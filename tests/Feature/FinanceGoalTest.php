<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FinanceGoal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceGoalTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_their_own_goal(): void
    {
        $user = User::factory()->create();
        $goal = FinanceGoal::create([
            'user_id' => $user->id,
            'name' => 'Car Purchase',
            'target_amount' => 50000000,
            'current_amount' => 10000000,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('finance.goals.destroy', $goal->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Цель успешно удалена!');
        
        $this->assertDatabaseMissing('finance_goals', [
            'id' => $goal->id,
        ]);
    }

    public function test_user_cannot_delete_other_users_goal(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $goal = FinanceGoal::create([
            'user_id' => $user2->id,
            'name' => 'House Purchase',
            'target_amount' => 100000000,
            'current_amount' => 20000000,
        ]);

        $response = $this
            ->actingAs($user1)
            ->delete(route('finance.goals.destroy', $goal->id));

        $response->assertStatus(404);
        
        $this->assertDatabaseHas('finance_goals', [
            'id' => $goal->id,
        ]);
    }

    public function test_user_can_reset_their_own_goal_accumulation(): void
    {
        $user = User::factory()->create();
        $goal = FinanceGoal::create([
            'user_id' => $user->id,
            'name' => 'Vacation',
            'target_amount' => 15000000,
            'current_amount' => 5000000,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('finance.goals.reset', $goal->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Накопления цели сброшены!');

        $goal->refresh();
        $this->assertEquals(0, $goal->current_amount);
    }

    public function test_user_cannot_reset_other_users_goal_accumulation(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $goal = FinanceGoal::create([
            'user_id' => $user2->id,
            'name' => 'Laptop',
            'target_amount' => 10000000,
            'current_amount' => 3000000,
        ]);

        $response = $this
            ->actingAs($user1)
            ->post(route('finance.goals.reset', $goal->id));

        $response->assertStatus(404);
        
        $goal->refresh();
        $this->assertEquals(3000000, $goal->current_amount);
    }
}

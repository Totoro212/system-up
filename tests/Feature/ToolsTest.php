<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: страница инструментов успешно отображается и не содержит удаленные модули.
     */
    public function test_tools_page_can_be_rendered_without_removed_modules(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('tools'));

        $response->assertStatus(200);
        
        // Должны присутствовать актуальные модули
        $response->assertSee('Квесты');
        $response->assertSee('Рыночный терминал');
        $response->assertSee('Тренировка');
        $response->assertSee('Кодекс');

        // Не должны присутствовать удаленные модули
        $response->assertDontSee('Важные даты');
        $response->assertDontSee('Финансы');
        $response->assertDontSee('Жизненные цели');
    }
}

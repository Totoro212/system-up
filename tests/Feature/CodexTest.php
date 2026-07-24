<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CodexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: авторизованный пользователь может просматривать страницу Кодекса.
     */
    public function test_codex_page_renders_successfully_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('codex'));

        $response->assertStatus(200);
        $response->assertSee('Кодекс Охотника');
        $response->assertSee('Здоровье');
        $response->assertSee('Защита');
        $response->assertSee('Свобода');
        $response->assertSee('Близкие');
        $response->assertSee('Дело');
    }

    /**
     * Тест: неавторизованный пользователь перенаправляется на страницу входа.
     */
    public function test_codex_page_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('codex'));

        $response->assertRedirect(route('login'));
    }
}

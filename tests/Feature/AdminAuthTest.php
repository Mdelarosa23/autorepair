<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_view_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
        $response->assertSee('Dashboard');
    }

    public function test_authenticated_user_can_update_theme_colors(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/theme', [
            'light_accent' => '#123456',
            'light_background' => '#ABCDEF',
            'light_text' => '#111111',
            'dark_accent' => '#222222',
            'dark_background' => '#333333',
            'dark_text' => '#444444',
        ]);

        $response->assertRedirect('/admin/theme');
        $response->assertSessionHas('status', 'Theme colors updated successfully.');

        $this->assertSame('#123456', SiteSetting::getValue('light_accent'));
        $this->assertSame('#ABCDEF', SiteSetting::getValue('light_background'));
        $this->assertSame('#111111', SiteSetting::getValue('light_text'));
        $this->assertSame('#222222', SiteSetting::getValue('dark_accent'));
        $this->assertSame('#333333', SiteSetting::getValue('dark_background'));
        $this->assertSame('#444444', SiteSetting::getValue('dark_text'));
    }
}

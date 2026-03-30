<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_service(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/services', [
            'title' => 'Battery Replacement',
            'description' => 'Fast battery diagnostics and replacement service.',
            'icon_class' => 'bx bxs-battery',
            'link_url' => '#services',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', [
            'title' => 'Battery Replacement',
            'icon_class' => 'bx bxs-battery',
        ]);
    }

    public function test_admin_can_update_a_service(): void
    {
        $user = User::factory()->create();
        $service = Service::query()->create([
            'title' => 'Old Service',
            'description' => 'Old description',
            'icon_class' => 'bx bxs-wrench',
            'image_path' => 'assets/img/home-one/service/1.jpg',
            'link_url' => '#services',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->put("/admin/services/{$service->id}", [
            'title' => 'Updated Service',
            'description' => 'Updated description',
            'icon_class' => 'bx bxs-cog',
            'link_url' => '#updated',
            'sort_order' => 3,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Updated Service',
            'icon_class' => 'bx bxs-cog',
            'sort_order' => 3,
        ]);
    }

    public function test_admin_can_delete_a_service(): void
    {
        $user = User::factory()->create();
        $service = Service::query()->create([
            'title' => 'Delete Me',
            'description' => 'To be deleted',
            'icon_class' => 'bx bxs-wrench',
            'image_path' => 'assets/img/home-one/service/1.jpg',
            'link_url' => '#services',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->delete("/admin/services/{$service->id}");

        $response->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_homepage_renders_active_services_from_database(): void
    {
        Service::query()->create([
            'title' => 'Visible Service',
            'description' => 'Shown on homepage',
            'icon_class' => 'bx bxs-star',
            'image_path' => 'assets/img/home-one/service/1.jpg',
            'link_url' => '#services',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Service::query()->create([
            'title' => 'Hidden Service',
            'description' => 'Should stay hidden',
            'icon_class' => 'bx bxs-hide',
            'image_path' => 'assets/img/home-one/service/1.jpg',
            'link_url' => '#services',
            'sort_order' => 2,
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Visible Service');
        $response->assertDontSee('Hidden Service');
    }
}

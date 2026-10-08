<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DashboardTest extends TestCase
{
    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_super_admin_can_log_in(): void
    {
        $this->seedCms();

        $this->post('/login', ['email' => 'admin@smoke.test', 'password' => 'Secret123!'])
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    public static function dashboardScreens(): array
    {
        return [
            'dashboard'   => ['/dashboard'],
            'pages'       => ['/dashboard/pages'],
            'page create' => ['/dashboard/page/create'],
            'menus'       => ['/dashboard/menus'],
            'forms'       => ['/dashboard/forms'],
            'resources'   => ['/dashboard/content/resources'],
            'repeaters'   => ['/dashboard/content/repeaters'],
            'users'       => ['/dashboard/users'],
            'redirects'   => ['/dashboard/redirects'],
            'templates'   => ['/dashboard/templates'],
            'settings'    => ['/dashboard/settings'],
        ];
    }

    #[DataProvider('dashboardScreens')]
    public function test_dashboard_screen_renders(string $uri): void
    {
        $admin = $this->seedCms();

        $this->actingAs($admin)->get($uri)->assertOk();
    }
}

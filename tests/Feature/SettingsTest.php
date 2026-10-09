<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;

class SettingsTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
    }

    public function test_site_settings_can_be_saved(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/settings/save', $this->settingsPayload())
            ->assertRedirect();

        $site = Site::firstOrFail();
        $this->assertSame('Renamed Site', $site->name);
        $this->assertSame('Acme', $site->settings['company']['name']);
        $this->assertSame('nl,en', $site->settings['lang']);
        $this->assertSame('http://smoke.test', $site->settings['domain']);
    }

    public function test_settings_without_any_language_are_rejected(): void
    {
        $payload = $this->settingsPayload();
        unset($payload['lang']);

        $this->actingAs($this->admin)
            ->post('/dashboard/settings/save', $payload)
            ->assertSessionHasErrors('lang');

        $this->assertSame('nl,en', Site::firstOrFail()->settings['lang']);
    }

    public function test_template_settings_can_be_saved(): void
    {
        $template = Template::firstOrFail();

        $this->actingAs($this->admin)
            ->post('/dashboard/templates/save', [
                'template_id'    => $template->id,
                'template_name'  => 'Fixture Template',
                'template_fonts' => 'Inter:400,700',
                'css_slug'    => ['main'],
                'css_href'    => ['css/main.css'],
                'css_asset'   => ['1'],
                'js_slug'     => [],
                'json_slug'   => [],
            ])
            ->assertRedirect();

        $template->refresh();
        $this->assertSame('css/main.css', $template->css['main']['href']);
    }

    private function settingsPayload(): array
    {
        $site = Site::firstOrFail();

        return [
            'site_id'      => $site->id,
            'site_name'    => 'Renamed Site',
            'site_slug'    => 'smoke',
            'site_domain'  => 'http://smoke.test',
            'company'      => ['name' => 'Acme', 'vat' => 'BE0000.000.000'],
            'socialmedia'  => ['facebook' => 'https://facebook.com/acme'],
            'favicon'      => ['href' => '/favicon.ico'],
            'logo'         => ['href' => '/logo.png'],
            'integrations' => ['ga-id' => ''],
            'lang'         => ['nl', 'en'],
        ];
    }
}

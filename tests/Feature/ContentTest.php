<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;

class ContentTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
    }

    public function test_repeater_entry_is_saved_with_detail_url_filled_in(): void
    {
        $this->saveRepeater(['action_detail_url' => 'team/[team_name]']);

        $this->saveEntry(['team_name' => 'jane', 'team_role' => 'Developer'])
            ->assertRedirect(route('dashboard.content.repeaters.entries', ['slug' => 'team']));

        $entry = Repeater::where('slug', 'team')->firstOrFail();
        $this->assertSame(['name' => 'jane', 'role' => 'Developer'], $entry->json);
        $this->assertSame('team/jane', $entry->url);
        $this->assertSame('Developer', $entry->role); // Repeater::__get, used by templates
    }

    public function test_repeater_entry_is_saved_when_detail_url_is_empty(): void
    {
        // The repeater form defaults the URL input to " ", which arrives as null.
        $this->saveRepeater(['action_detail_url' => ' ']);

        $this->saveEntry(['team_name' => 'jane', 'team_role' => 'Developer'])->assertRedirect();

        $this->assertNull(Repeater::where('slug', 'team')->firstOrFail()->url);
    }

    public function test_repeater_entry_validation_uses_the_field_rules(): void
    {
        $this->saveRepeater();

        $this->saveEntry(['team_name' => '', 'team_role' => 'Developer'])->assertSessionHasErrors('team_name');
        $this->assertSame(0, Repeater::count());
    }

    public function test_repeater_entry_can_be_deleted(): void
    {
        $this->saveRepeater();
        $this->saveEntry(['team_name' => 'jane', 'team_role' => 'Developer']);

        $this->actingAs($this->admin)
            ->post('/dashboard/content/repeaters/entries/delete', ['repeater_id' => Repeater::firstOrFail()->id])
            ->assertOk()
            ->assertSeeText('success');

        $this->assertSame(0, Repeater::count());
    }

    public function test_resource_can_be_saved_per_locale(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/content/resources/save', [
                'slug'           => ['footer'],
                'resource_key'   => ['nl' => ['tagline'], 'en' => ['tagline']],
                'resource_value' => ['nl' => ['Hallo'], 'en' => ['Hello']],
            ])
            ->assertRedirect(route('dashboard.content.resources'));

        $resource = Resource::where('slug', 'footer')->firstOrFail();
        $this->assertEquals(['nl' => ['tagline' => 'Hallo'], 'en' => ['tagline' => 'Hello']], $resource->json);
    }

    public function test_redirect_is_created_and_followed_on_the_frontend(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/redirects/create', ['slug' => 'old-page', 'to' => '/new-page', 'type' => 301])
            ->assertRedirect();

        $this->assertSame('/new-page', Redirect::where('slug', 'old-page')->firstOrFail()->to);

        auth()->logout();
        $this->withHeader('Accept-Language', 'nl')
            ->get('/old-page')
            ->assertStatus(301)
            ->assertRedirect('/new-page');
    }

    private function saveRepeater(array $overrides = [])
    {
        return $this->actingAs($this->admin)->post('/dashboard/content/repeaters/save', array_replace([
            'content_slug'       => 'team',
            'content_type'       => 'repeater',
            'fields_slug'        => ['name', 'role'],
            'fields_label'       => ['Name', 'Role'],
            'fields_type'        => ['text', 'text'],
            'fields_class'       => ['form-control', 'form-control'],
            'fields_placeholder' => ['', ''],
            'fields_validation'  => ['required', 'nullable'],
            'fields_value'       => ['', ''],
            'fields_attributes_name'  => ['', ''],
            'fields_attributes_value' => ['', ''],
            'fields_required'    => ['true', 'false'],
            'fields_table'       => ['true', 'false'],
            'action_store'       => 'true',
            'action_detail'      => 'true',
            'action_detail_url'  => 'team/[team_name]',
            'action_detail_page' => 'chuck-fixture::templates.fixture.page',
            'files_allowed'      => 'false',
        ], $overrides))->assertRedirect();
    }

    private function saveEntry(array $fields)
    {
        return $this->actingAs($this->admin)
            ->post('/dashboard/content/repeaters/entries/save', ['content_slug' => 'team'] + $fields);
    }
}

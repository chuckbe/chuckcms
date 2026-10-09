<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Tests\TestCase;

class PageTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->seedCms();
    }

    public function test_page_can_be_created(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/page/save', $this->pagePayload())
            ->assertRedirect(route('dashboard.pages'));

        $page = Page::firstOrFail();
        $this->assertSame('home', $page->getTranslation('slug', 'nl'));
        $this->assertSame('Home', $page->getTranslation('title', 'en'));
        $this->assertSame(Template::first()->id, (int) $page->template_id);
        $this->assertSame('Sandbox', $page->meta['nl']['author']);
    }

    public function test_page_can_be_updated(): void
    {
        $this->actingAs($this->admin)->post('/dashboard/page/save', $this->pagePayload());
        $page = Page::firstOrFail();

        $payload = $this->pagePayload(['page_title' => ['nl' => 'Thuis', 'en' => 'Home']]);
        unset($payload['create']);
        $payload['update'] = 1;
        $payload['page_id'] = $page->id;

        $this->actingAs($this->admin)
            ->post('/dashboard/page/save', $payload)
            ->assertRedirect(route('dashboard.pages'));

        $this->assertSame('Thuis', $page->fresh()->getTranslation('title', 'nl'));
        $this->assertSame(1, Page::count());
    }

    public function test_page_and_its_blocks_can_be_deleted(): void
    {
        $page = $this->createPage();
        $this->addBlock($page, 'add-block-top', 'heroes/hero.html');

        $this->actingAs($this->admin)
            ->post('/dashboard/page/delete', ['page_id' => $page->id])
            ->assertOk()
            ->assertSeeText('success');

        $this->assertSame(0, Page::count());
        $this->assertSame(0, PageBlock::count());
    }

    public function test_page_builder_renders(): void
    {
        $page = $this->createPage();

        $this->actingAs($this->admin)
            ->get("/dashboard/page/{$page->id}-edit/builder?lang=nl")
            ->assertOk()
            ->assertSee('data-location="'.$this->templatePath().'/blocks/heroes/hero.html"', false);
    }

    public function test_blocks_are_added_at_top_and_bottom_in_order(): void
    {
        $page = $this->createPage();

        $this->addBlock($page, 'add-block-top', 'heroes/hero.html', 'first')->assertOk()->assertSeeText('success');
        $this->addBlock($page, 'add-block-bottom', 'sections/cta.html', 'last')->assertOk();
        $this->addBlock($page, 'add-block-top', 'heroes/hero.html', 'new-first')->assertOk();

        $this->assertSame(
            ['new-first' => 1, 'first' => 2, 'last' => 3],
            PageBlock::where('page_id', $page->id)->orderBy('order')->pluck('order', 'name')->map(fn ($o) => (int) $o)->all(),
        );
        $this->assertStringContainsString('Fixture hero', PageBlock::where('name', 'first')->first()->body);
    }

    public function test_block_location_outside_the_template_is_rejected(): void
    {
        $page = $this->createPage();
        $blocks = $this->templatePath().'/blocks';

        foreach ([
            $blocks.'/../../../../phpunit.xml',     // traversal
            '/etc/hosts',                          // absolute path
            __DIR__.'/../fixtures/views/templates/fixture/page.blade.php',
            $blocks.'/missing.html',
        ] as $location) {
            $this->actingAs($this->admin)
                ->postJson('/pageblock/add-block-top', ['location' => $location, 'page_id' => $page->id, 'name' => 'evil'])
                ->assertNotFound();
        }

        $this->assertSame(0, PageBlock::count());
    }

    public function test_blocks_can_be_moved_edited_and_deleted(): void
    {
        $page = $this->createPage();
        $this->addBlock($page, 'add-block-bottom', 'heroes/hero.html', 'a');
        $this->addBlock($page, 'add-block-bottom', 'sections/cta.html', 'b');
        $this->addBlock($page, 'add-block-bottom', 'heroes/hero.html', 'c');
        $b = PageBlock::where('name', 'b')->first();

        $this->actingAs($this->admin)->postJson('/pageblock/move-up', ['pageblock_id' => $b->id])->assertOk();
        $this->assertSame(['b', 'a', 'c'], $this->blockNames($page));

        $this->actingAs($this->admin)->postJson('/pageblock/move-down', ['pageblock_id' => $b->id])->assertOk();
        $this->assertSame(['a', 'b', 'c'], $this->blockNames($page));

        $this->actingAs($this->admin)
            ->postJson('/pageblock/update', ['pageblock_id' => $b->id, 'html' => '<p>Edited [%URL%]</p>'])
            ->assertOk()
            ->assertJsonPath('raw', '<p>Edited [%URL%]</p>');

        $this->actingAs($this->admin)
            ->post('/pageblock/delete', ['pageblock_id' => $b->id])
            ->assertOk()
            ->assertSeeText('success');
        $this->assertSame(['a', 'c'], $this->blockNames($page));
        $this->assertSame([1, 2], PageBlock::orderBy('order')->pluck('order')->map(fn ($o) => (int) $o)->all());
    }

    public function test_homepage_renders_its_blocks(): void
    {
        $page = $this->createPage();
        $this->addBlock($page, 'add-block-top', 'heroes/hero.html');

        // Browsers always send Accept-Language; without it the localization
        // middleware negotiates a locale and redirects.
        $this->withHeader('Accept-Language', 'nl')
            ->get('/')
            ->assertOk()
            ->assertSee('Fixture hero')
            ->assertSee('http://smoke.test', false); // [%URL%] tag rendered
    }

    private function createPage(): Page
    {
        $this->actingAs($this->admin)->post('/dashboard/page/save', $this->pagePayload());

        return Page::firstOrFail();
    }

    private function addBlock(Page $page, string $endpoint, string $file, string $name = 'block')
    {
        return $this->actingAs($this->admin)->postJson("/pageblock/{$endpoint}", [
            'location' => $this->templatePath().'/blocks/'.$file,
            'page_id'  => $page->id,
            'name'     => $name,
            'lang'     => 'nl',
        ]);
    }

    private function blockNames(Page $page): array
    {
        return PageBlock::where('page_id', $page->id)->orderBy('order')->pluck('name')->all();
    }

    private function pagePayload(array $overrides = []): array
    {
        $payload = [
            'create'      => 1,
            'template_id' => Template::first()->id,
            'page'        => '',
            'active'      => 1,
            'isHp'        => 1,
            'meta_image'  => '',
        ];

        foreach (['nl', 'en'] as $lang) {
            $payload['page_title'][$lang] = 'Home';
            $payload['page_slug'][$lang] = 'home';
            $payload['slug'][$lang] = 'home';
            $payload['meta_title'][$lang] = 'Home';
            $payload['meta_description'][$lang] = 'Description';
            $payload['meta_keywords'][$lang] = 'keywords';
            $payload['meta_robots_index'][$lang] = 1;
            $payload['meta_robots_follow'][$lang] = 1;
            $payload['meta_key'][$lang] = ['author'];
            $payload['meta_value'][$lang] = ['Sandbox'];
        }

        return array_replace($payload, $overrides);
    }
}

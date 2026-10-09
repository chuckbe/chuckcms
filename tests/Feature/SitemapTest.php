<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Tests\TestCase;
use Illuminate\Support\Facades\File;

class SitemapTest extends TestCase
{
    protected function tearDown(): void
    {
        File::delete(public_path('sitemap.xml'));

        parent::tearDown();
    }

    public function test_sitemap_command_writes_a_sitemap(): void
    {
        // Nothing listens on this port, so the crawl finds no pages; this
        // checks the command and the laravel-sitemap API it relies on.
        config(['app.url' => 'http://127.0.0.1:9']);

        $this->artisan('chuckcms:generate-sitemap')->assertSuccessful();

        $this->assertFileExists(public_path('sitemap.xml'));
        $this->assertStringContainsString('<urlset', File::get(public_path('sitemap.xml')));
    }
}

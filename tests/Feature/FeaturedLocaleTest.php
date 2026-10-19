<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Tests\TestCase;

class FeaturedLocaleTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        // Only the default locale should decide, not the browser's language.
        $app['config']->set('lang.useAcceptLanguageHeader', false);
        $app['config']->set('lang.featuredLocale', 'en');
    }

    public function test_the_featured_locale_becomes_the_default_locale(): void
    {
        $this->seedCms();
        $this->createHomepage();

        $this->assertSame('en', app()->getLocale());
        $this->assertSame('en', app('laravellocalization')->getDefaultLocale());

        $this->get('/')->assertOk()->assertSee('<title>Welcome</title>', false);
    }
}

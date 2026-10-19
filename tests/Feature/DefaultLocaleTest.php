<?php

namespace Chuckbe\Chuckcms\Tests\Feature;

use Chuckbe\Chuckcms\Tests\TestCase;

class DefaultLocaleTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        // Only the default locale should decide, not the browser's language.
        $app['config']->set('lang.useAcceptLanguageHeader', false);
    }

    public function test_dutch_is_the_default_locale_out_of_the_box(): void
    {
        $this->seedCms();
        $this->createHomepage();

        $this->assertSame('nl', app()->getLocale());
        $this->assertSame('nl', app('laravellocalization')->getDefaultLocale());

        $this->get('/')->assertOk()->assertSee('<title>Welkom</title>', false);
    }
}

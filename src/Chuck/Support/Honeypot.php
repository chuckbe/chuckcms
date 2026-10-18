<?php

namespace Chuckbe\Chuckcms\Chuck\Support;

use Illuminate\Support\HtmlString;
use Spatie\Honeypot\Honeypot as HoneypotSetup;

/**
 * Backwards-compatible `Honeypot` alias for templates written against
 * msurguy/honeypot, which call `Honeypot::generate('chuck_telephone', 'chuck_email')`.
 *
 * Renders the spatie/laravel-honeypot fields instead; the field names it
 * was given are ignored because spatie's own names are what the
 * ProtectAgainstSpam middleware checks.
 *
 * @deprecated Use the `<x-honeypot />` Blade component in templates.
 */
class Honeypot
{
    public static function generate(string ...$legacyFieldNames): HtmlString
    {
        return new HtmlString(
            view('honeypot::honeypotFormFields', app(HoneypotSetup::class)->toArray())->render()
        );
    }
}

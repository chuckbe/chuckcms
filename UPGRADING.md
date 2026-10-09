# Upgrading

## From 0.2 to 0.3

0.3 is the cleanup and Laravel 11/12 release. Most sites only need the
**Requirements**, **Honeypot** and **spatie/laravel-permission** steps.

### Requirements

- PHP 8.2 or higher (was 8.0).
- Laravel 10, 11 or 12 (Laravel 9 is no longer supported).

Composer 2.9 and newer refuse to install packages with known security
advisories. The latest Laravel 10 and 11 releases still have some, so on
those versions `composer update` may stop with "affected by security
advisories". Upgrading the site to Laravel 12 is the real fix; until then
you can run `composer config audit.block-insecure false` in the site.

### Honeypot

`msurguy/honeypot` is replaced by `spatie/laravel-honeypot`.

- Templates that call `Honeypot::generate('chuck_telephone', 'chuck_email')`
  keep working: the `Honeypot` alias now renders the new fields. Replace those
  calls with `<x-honeypot />` when you next touch the template.
- The hidden fields are now named `my_name_<random>` and `valid_from` instead
  of `chuck_telephone` and `chuck_email`. JavaScript or CSS that targets the
  old names needs updating.
- Spam now gets an empty 200 response instead of a validation error.
- The minimum time to fill in a form drops from 12 seconds to 1. Set
  `HONEYPOT_SECONDS=12` in `.env` to keep the old behaviour.
- Submissions without the honeypot fields are no longer rejected. To require
  them on every form, publish the config (`php artisan vendor:publish
  --tag=honeypot-config`) and set `honeypot_fields_required_for_all_forms`
  to `true`.

### spatie/laravel-permission v6

- If your own code references the middleware classes, rename
  `Spatie\Permission\Middleware`**`s`**`\…` to `Spatie\Permission\Middleware\…`.
  ChuckCMS registers the `role`, `permission` and `role_or_permission` aliases
  itself.
- Compare your published `config/permission.php` with the
  [v6 config](https://github.com/spatie/laravel-permission/blob/main/config/permission.php);
  no database migration is needed when you don't use teams.

### PDFs (barryvdh/laravel-dompdf v3)

ChuckCMS itself doesn't render PDFs, but modules such as booker, ecommerce and
order-form do. dompdf v3 no longer loads remote files by default, so images
referenced by URL (for example `asset(...)` logos in invoices) disappear. Use
local paths (`public_path(...)`) in PDF views, or enable remote loading in
`config/dompdf.php` (`enable_remote` plus `allowed_remote_hosts`).

### Other changes

- **User activation**: passwords must be at least 8 characters with upper- and
  lowercase letters, a number and a symbol. Previously a letter and a number
  were enough.
- **Container**: ChuckCMS no longer binds `App\User` to its User model. Resolve
  `Chuckbe\Chuckcms\Models\User` instead.
- **Removed methods**: business logic moved from models and repositories into
  action classes under `src/Actions`, and three copies of the tag parser became
  `Chuck\Support\TagParser::between()`. If your templates or app call any of
  these, switch to the matching action or a plain Eloquent query:
  - `Page`: `getById()`, `deleteById()`
  - `PageBlock`: `getById()`, `getRenderedById()`, `getCountByPageId()`,
    `moveUpById()`, `moveDownById()`, `moveOrderDownByPageId()`,
    `addBlockTop()`, `addBlockBottom()`
  - `Form`: `getBySlug()`, `getRules()`, `storeEntry()`, `getMailData()`,
    `deleteById()`, `deleteBySlug()`, `getResources()`
  - `FormEntry`: `getById()`, `getBySlug()`
  - `Content`: `getBySlug()`, `getRules()`, `storeEntry()`, `deleteById()`,
    `getUrlFromInput()`, `getContents()`
  - `Template`: `updateFromRequest()`
  - `User`: `deleteById()`
  - `Chuck\PageBlockRepository`: `moveUpById()`, `moveDownById()`,
    `moveOrderDownByPageId()`, `moveOrderUpByPageId()`, `deleteById()`,
    `getResources()`
  - `Chuck\PageRepository`: the whole class
  - `PageController::dirToArray()`: now `Chuck\Support\TemplateBlocks::scan()`

  `Chuck\UserRepository`, `Chuck\ModuleRepository`, `Chuck\SiteRepository`
  and `Repeater::__get()` are unchanged.
- **Missing records** now return 404 instead of a server error.

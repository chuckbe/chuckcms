# ChuckCMS

[![Latest Stable Version](https://poser.pugx.org/chuckbe/chuckcms/version.png)](https://packagist.org/packages/chuckbe/chuckcms) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/build-status/master) [![Total Downloads](https://poser.pugx.org/chuckbe/chuckcms/d/total.png)](https://packagist.org/packages/chuckbe/chuckcms)

## Features

ChuckCMS is an opinionated way of building websites and webshops in Laravel. ChuckCMS provides out-of-the-box ui and features by packages in the Laravel eco-system.

- Dashboard with analytics by GA or Matomo.
- Menus, navigation and redirects.
- Page management with Pagebuilder.
- User, role and permission management.
- File management.
- Form management.
- Repeaters and resources, a way to create data objects.
- Settings and configuration management.

## Docs

### Requirements
- PHP 8
- Laravel 9 / 10 

### Installation
> ChuckCMS will work best in a fresh installation.

Install ChuckCMS in a freshly scaffolded Laravel project via Composer:
```
composer require chuckbe/chuckcms
```

### Publish assets and config
You can now publish all assets and config files this package needs:
```
php artisan vendor:publish --provider="Chuckbe\Chuckcms\ChuckcmsServiceProvider"
```

### Packages
#### ```unisharp/laravel-filemanager``` package
You can now publish assets for ```unisharp/laravel-filemanager```:
```
php artisan vendor:publish --tag=lfm_public
```

#### ```spatie/laravel-permission``` package
You can now publish migrations and config file for ```spatie/laravel-permission```:
```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
> There is no need to add the middleware for this package. It is already being loaded by ChuckCMS.

### Migration
You can now run migrations:
```
php artisan migrate
```
> Make sure you've added DB credentials to your ```.env``` file.

### Routes
You can now add the routes for this package:
```php
Chuck::auth();
Chuck::routes();
Chuck::frontend();
```

### New site
You can now generate a new site with the following command:
```
php artisan chuckcms:generate-site
```

### Generate default roles and permission
```
php artisan chuckcms:generate-roles-permissions
```

### Generate super admin
```
php artisan chuckcms:generate-super-admin
```

### Visit http://yourapp.local/dashboard/pages

### Create a new page

### Generate a sitemap
```
php artisan chuckcms:generate-sitemap
```

## License

Licensed under [MIT license](http://opensource.org/licenses/MIT).

## Author

**Written by [Karel Brijs](https://twitter.com/karelbrijs) in Antwerp.**

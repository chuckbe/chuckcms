# ChuckCMS

[![Latest Stable Version](https://poser.pugx.org/chuckbe/chuckcms/version.png)](https://packagist.org/packages/chuckbe/chuckcms) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/build-status/master) [![Total Downloads](https://poser.pugx.org/chuckbe/chuckcms/d/total.png)](https://packagist.org/packages/chuckbe/chuckcms)

## Instructions

### How to use these instructions?

ChuckCMS was created to add CMS functionality to an existing Laravel project. The package will take over all incoming routes except for existing one you might have for custom functionality. ChuckCMS will work best in a fresh installation, this package is not created for adding it to existing projects.

## Installation guide

### Install with composer
```
composer require chuckbe/chuckcms
```

### Publish public assets
```
php artisan vendor:publish --tag=chuckcms-public --force
php artisan vendor:publish --tag=lfm_public //Laravel Filemanager by UniSharp
```

### Eventually publish config files
```
php artisan vendor:publish --tag=chuckcms-config --force
```

### Add Permission middleware from the Spatie package
```php
// App\Http\Kernel.php


protected $routeMiddleware = [
    ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

### Migrate the database
```
php artisan migrate
```

### Generate a new site with following command
```
php artisan chuckcms:generate-site
```

### Generate all default roles and permission
```
php artisan chuckcms:generate-roles-permissions
```

### Make a new super admin with following command
```
php artisan chuckcms:generate-super-admin
```

### Go to http://yourapp.local/dashboard/pages

### Create a new page

### Generate a sitemap
```
php artisan chuckcms:generate-sitemap
```

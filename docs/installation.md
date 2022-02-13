---
layout: default
title: Installation
nav_order: 2
---
## Installation

[![Latest Stable Version](https://poser.pugx.org/chuckbe/chuckcms/version.png)](https://packagist.org/packages/chuckbe/chuckcms) [![Total Downloads](https://poser.pugx.org/chuckbe/chuckcms/d/total.png)](https://packagist.org/packages/chuckbe/chuckcms)

---

## Table of contents
{: .no_toc .text-delta }

1. TOC
{:toc}

---
 
### Requirements
This package can be used with Laravel 6.20.26 or higher. 

### Composer
You can install the package via composer:
```
composer require chuckbe/chuckcms
```

### Assets
You can now publish all assets this package needs.
```
php artisan vendor:publish --tag=chuckcms-public --force
php artisan vendor:publish --tag=lfm_public //Laravel Filemanager by UniSharp
```

### Configuration
You can now publish the config file for this package.
```
php artisan vendor:publish --tag=chuckcms-config --force
```

### ```spatie/laravel-permission``` package
You can now add the necessary middleware for ```spatie/laravel-permission```:
```php
// App\Http\Kernel.php


protected $routeMiddleware = [
    ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

You can now publish migrations and config file for ```spatie/laravel-permission```:
```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### Migration
You can now migrate the database:
```
php artisan migrate
```
> Make sure you've added DB credentials to your ```.env``` file.

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
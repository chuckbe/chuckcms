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
];
```

### Migrate the database
```
php artisan migrate
```

### Generate a new site
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
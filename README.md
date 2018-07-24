# chuckcms

[![Latest Stable Version](https://poser.pugx.org/chuckbe/chuckcms/version.png)](https://packagist.org/packages/chuckbe/chuckcms) [![Total Downloads](https://poser.pugx.org/chuckbe/chuckcms/d/total.png)](https://packagist.org/packages/chuckbe/chuckcms)

## Instructions

- How to use these instructions?

ChuckCMS was created to add CMS functionality to an existing Laravel project. The package will take over all incoming routes except for existing one you might have for custom functionality. ChuckCMS will work best in a fresh installation, this package is not created for adding it to existing projects.

### Installation guide

- Install with composer
```
composer require chuckbe/chuckcms
```

- Publish public assets
```
php artisan vendor:publish --tag=chuckcms-public --force
```

- Eventually publish config files
```
php artisan vendor:publish --tag=chuckcms-config --force
```

- publish error views?

- Add Spatie's Permission package middleware to App\Kernel $protectedMiddleware array
```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
```

- migrate
```
php artisan migrate
```

- seed
```
php artisan db:seed --class=Chuckbe\\Chuckcms\\migrations\\seeds\\PermissionRolesTableSeeder
```
- make a new site with following command
```
php artisan chuckcms:generate-site
```
- make a new super admin with following command
```
php artisan chuckcms:generate-super-admin
```
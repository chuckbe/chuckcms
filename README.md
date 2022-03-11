# ChuckCMS

[![Latest Stable Version](https://poser.pugx.org/chuckbe/chuckcms/version.png)](https://packagist.org/packages/chuckbe/chuckcms) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/chuckbe/chuckcms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/chuckbe/chuckcms/build-status/master) [![Total Downloads](https://poser.pugx.org/chuckbe/chuckcms/d/total.png)](https://packagist.org/packages/chuckbe/chuckcms)

## Instructions

### How to use these instructions?

ChuckCMS was created to add CMS functionality to an existing Laravel project. The package will take over all incoming routes except for existing one you might have for custom functionality. ChuckCMS will work best in a fresh installation, this package is not created for adding it to existing projects.

## Installation guide

### Requirements
This package can be used with Laravel 6.20.26 or higher. 

For Laravel 7 and higher the ```laravel/ui``` package is required.

### Composer
You can install the package via composer:
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

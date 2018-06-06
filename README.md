# chuckcms

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
php artisan vendor:publish --tag=chuckcmspublic --force
```
- Eventually publish config files
```
php artisan vendor:publish --tag=chuckcmsconfig --force
```
- publish error views?
- add permission/role middleware
- migrate
- seed
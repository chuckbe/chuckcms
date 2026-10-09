<?php

// spatie/laravel-permission ships its migration as a publishable stub
// declaring a named class, so load it once and hand the migrator an instance.
require_once __DIR__.'/../../../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub';

return new CreatePermissionTables();

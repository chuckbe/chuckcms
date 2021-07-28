<?php

Route::group(['middleware' => ['web']], function() {
// Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => config('chuckcms.auth.get_login.controller').'@'.config('chuckcms.auth.get_login.action')]);
    Route::post('login', ['as' => 'login.post', 'uses' => config('chuckcms.auth.post_login.controller').'@'.config('chuckcms.auth.post_login.action')]);
    Route::post('logout', ['as' => 'logout', 'uses' => config('chuckcms.auth.post_logout.controller').'@'.config('chuckcms.auth.post_logout.action')]);

// Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => config('chuckcms.auth.get_register.controller').'@'.config('chuckcms.auth.get_register.action')]);
    Route::post('register', ['as' => 'register.post', 'uses' => config('chuckcms.auth.post_register.controller').'@'.config('chuckcms.auth.post_register.action')]);

// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => config('chuckcms.auth.get_password_reset.controller').'@'.config('chuckcms.auth.get_password_reset.action')]);
    Route::post('password/email', ['as' => 'password.email', 'uses' => config('chuckcms.auth.post_password_email.controller').'@'.config('chuckcms.auth.post_password_email.action')]);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => config('chuckcms.auth.get_password_reset_token.controller').'@'.config('chuckcms.auth.get_password_reset_token.action')]);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => config('chuckcms.auth.post_password_reset.controller').'@'.config('chuckcms.auth.post_password_reset.action')]);
});

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => 'auth'], function () {
    // Dashboard Routes...
        Route::get('/dashboard', 'Chuckbe\Chuckcms\Controllers\DashboardController@index')->name('dashboard');
    // Dashboard Pages Routes...
        Route::group(['middleware' => ['permission:show pages']], function () {
            Route::get('/dashboard/pages', 'Chuckbe\Chuckcms\Controllers\PageController@index')->name('dashboard.pages');
        });
        Route::group(['middleware' => ['permission:create pages']], function () {
            Route::get('/dashboard/page/create', 'Chuckbe\Chuckcms\Controllers\PageController@create')->name('dashboard.page.create');
            Route::post('/dashboard/page/save', 'Chuckbe\Chuckcms\Controllers\PageController@save')->name('dashboard.page.save');
        });
		
        Route::group(['middleware' => ['permission:edit pages']], function () {
            Route::get('/dashboard/page/{page_id}-edit', 'Chuckbe\Chuckcms\Controllers\PageController@edit')->name('dashboard.page.edit');
            Route::get('/dashboard/page/{page_id}-move-up', 'Chuckbe\Chuckcms\Controllers\PageController@moveUp')->name('dashboard.page.move.up');
            Route::get('/dashboard/page/{page_id}-move-first', 'Chuckbe\Chuckcms\Controllers\PageController@moveFirst')->name('dashboard.page.move.first');
            Route::get('/dashboard/page/{page_id}-move-down', 'Chuckbe\Chuckcms\Controllers\PageController@moveDown')->name('dashboard.page.move.down');
            Route::get('/dashboard/page/{page_id}-move-last', 'Chuckbe\Chuckcms\Controllers\PageController@moveLast')->name('dashboard.page.move.last');
        });

        Route::group(['middleware' => ['permission:delete pages']], function () {
            Route::post('/dashboard/page/delete', 'Chuckbe\Chuckcms\Controllers\PageController@delete')->name('dashboard.page.delete');
        });
    // Dashboard Page Builder Routes...
        Route::group(['middleware' => ['permission:show pagebuilder']], function () {
            Route::get('/dashboard/page/{page_id}-edit/builder', 'Chuckbe\Chuckcms\Controllers\PageController@builderIndex')->name('dashboard.page.edit.pagebuilder');
            Route::get('/dashboard/page/{page_id}/raw', 'Chuckbe\Chuckcms\Controllers\PageController@builderRaw')->name('dashboard.page.raw');    
        });

        Route::group(['middleware' => ['permission:edit pagebuilder']], function () {
            Route::post('/pageblock/show', 'Chuckbe\Chuckcms\Controllers\PageBlockController@show')->name('api.pageblock.show');
            Route::post('/pageblock/update', 'Chuckbe\Chuckcms\Controllers\PageBlockController@update')->name('api.pageblock.update');
            Route::post('/pageblock/move-up', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveUp')->name('api.pageblock.move_up');
            Route::post('/pageblock/move-down', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveDown')->name('api.pageblock.move_down');
            Route::post('/pageblock/add-block-top', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockTop')->name('api.pageblock.add_block_top');
            Route::post('/pageblock/add-block-bottom', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockBottom')->name('api.pageblock.add_block_bottom');
        });

        Route::group(['middleware' => ['permission:delete pagebuilder']], function () {
            Route::post('/pageblock/delete', 'Chuckbe\Chuckcms\Controllers\PageBlockController@delete')->name('api.pageblock.delete');
        });
		
    // Dashboard Menus Routes...
        Route::group(['middleware' => ['permission:show menus']], function () {
            $path = rtrim(config('menu.route_path'));
            Route::get('/dashboard/menus', 'Chuckbe\Chuckcms\Controllers\MenuController@index')->name('dashboard.menus');
            Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratemenucontrol', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@generatemenucontrol'));
        });

        Route::group(['middleware' => ['permission:create menus']], function () {
            $path = rtrim(config('menu.route_path'));
            Route::post($path . '/addcustommenu', array('as' => 'haddcustommenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@addcustommenu'));
            Route::post($path . '/addpagemenu', array('as' => 'haddpagemenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@addpagemenu'));
            Route::post($path . '/createnewmenu', array('as' => 'hcreatenewmenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@createnewmenu'));
        });

        Route::group(['middleware' => ['permission:edit menus']], function () {
            $path = rtrim(config('menu.route_path'));
            Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratemenucontrol', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@generatemenucontrol'));
            Route::post($path . '/updateitem', array('as' => 'hupdateitem', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@updateitem'));
        });

        Route::group(['middleware' => ['permission:delete menus']], function () {
            $path = rtrim(config('menu.route_path'));
            Route::post($path . '/deleteitemmenu', array('as' => 'hdeleteitemmenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@deleteitemmenu'));
            Route::post($path . '/deletemenug', array('as' => 'hdeletemenug', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@deletemenug'));
        });

    // Dashboard Redirects Routes...
        Route::group(['middleware' => ['permission:show redirects']], function () {
            Route::get('/dashboard/redirects', 'Chuckbe\Chuckcms\Controllers\RedirectController@index')->name('dashboard.redirects');
        });

        Route::group(['middleware' => ['permission:create redirects']], function () {
            Route::post('/dashboard/redirects/create', 'Chuckbe\Chuckcms\Controllers\RedirectController@create')->name('dashboard.redirects.create');
        });

        Route::group(['middleware' => ['permission:edit redirects']], function () {
            Route::post('/dashboard/redirects/update', 'Chuckbe\Chuckcms\Controllers\RedirectController@update')->name('dashboard.redirects.update');
        });

        Route::group(['middleware' => ['permission:delete redirects']], function () {
            Route::post('/dashboard/redirects/delete', 'Chuckbe\Chuckcms\Controllers\RedirectController@delete')->name('dashboard.redirects.delete');
        });
		
		
    // Dashboard Templates Routes...
        Route::group(['middleware' => ['permission:show templates']], function () {
            Route::get('/dashboard/templates', 'Chuckbe\Chuckcms\Controllers\TemplateController@index')->name('dashboard.templates');
        });
        Route::group(['middleware' => ['permission:edit templates']], function () {
            Route::get('/dashboard/templates/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\TemplateController@edit')->name('dashboard.templates.edit');
            Route::post('/dashboard/templates/save', 'Chuckbe\Chuckcms\Controllers\TemplateController@save')->name('dashboard.templates.save');
        });
		
    // Dashboard Forms Routes...
        Route::group(['middleware' => ['permission:show forms']], function () {
            Route::get('/dashboard/forms', 'Chuckbe\Chuckcms\Controllers\FormController@index')->name('dashboard.forms');
        });

        Route::group(['middleware' => ['permission:create forms']], function () {
            Route::post('/dashboard/forms/create', 'Chuckbe\Chuckcms\Controllers\FormController@create')->name('dashboard.forms.create');
            Route::post('/dashboard/forms/save', 'Chuckbe\Chuckcms\Controllers\FormController@save')->name('dashboard.forms.save');
        });
		
        Route::group(['middleware' => ['permission:edit forms']], function () {
            Route::get('/dashboard/forms/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\FormController@edit')->name('dashboard.forms.edit');
        });

        Route::group(['middleware' => ['permission:delete forms']], function () {
            Route::post('/dashboard/forms/delete', 'Chuckbe\Chuckcms\Controllers\FormController@delete')->name('dashboard.forms.delete');
        });
    // Dashboard Forms Entries Routes...
        Route::group(['middleware' => ['permission:show formentry']], function () {
            Route::get('/dashboard/forms/{slug}/entry/{id}', 'Chuckbe\Chuckcms\Controllers\FormController@entry')->name('dashboard.forms.entry');
        });

        Route::group(['middleware' => ['permission:show formentries']], function () {
            Route::get('/dashboard/forms/{slug}/entries', 'Chuckbe\Chuckcms\Controllers\FormController@entries')->name('dashboard.forms.entries');
        });

        Route::group(['middleware' => ['permission:create formentries']], function () {
			
        });

        Route::group(['middleware' => ['permission:edit formentries']], function () {
			
        });

        Route::group(['middleware' => ['permission:delete formentries']], function () {
			
        });

	
    // Dashboard Content Resource Routes...
        Route::group(['middleware' => ['permission:show resource']], function () {
            Route::get('/dashboard/content/resources', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceIndex')->name('dashboard.content.resources');
        });

        Route::group(['middleware' => ['permission:create resource']], function () {
            Route::get('/dashboard/content/resources/create', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceCreate')->name('dashboard.content.resources.create');
            Route::post('/dashboard/content/resources/save', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceSave')->name('dashboard.content.resources.save');
        });

        Route::group(['middleware' => ['permission:edit resource']], function () {
            Route::get('/dashboard/content/resources/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceEdit')->name('dashboard.content.resources.edit');
        });

        Route::group(['middleware' => ['permission:delete resource']], function () {
			Route::post('/dashboard/content/resources/delete', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceDelete')->name('dashboard.content.resources.delete');
        });
		
    // Dashboard Content Repeaters Routes...		
        Route::group(['middleware' => ['permission:show repeaters']], function () {
            Route::get('/dashboard/content/repeaters', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterIndex')->name('dashboard.content.repeaters');
            Route::get('/dashboard/content/repeaters/{slug}/json', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterJson')->name('dashboard.content.repeaters.json');
        });

        Route::group(['middleware' => ['permission:create repeaters']], function () {
            Route::get('/dashboard/content/repeaters/create', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterCreate')->name('dashboard.content.repeaters.create');
            Route::post('/dashboard/content/repeaters/save', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterSave')->name('dashboard.content.repeaters.save');
            Route::post('/dashboard/content/repeaters/import', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterImport')->name('dashboard.content.repeaters.import');
        });

        Route::group(['middleware' => ['permission:edit repeaters']], function () {
            Route::get('/dashboard/content/repeaters/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEdit')->name('dashboard.content.repeaters.edit');
        });

        Route::group(['middleware' => ['permission:delete repeaters']], function () {
			Route::post('/dashboard/content/repeaters/delete', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterDelete')->name('dashboard.content.repeaters.delete');
        });
    // Dashboard Content Repeaters Entries Routes...
        Route::group(['middleware' => ['permission:show repeaters entries']], function () {
            Route::get('/dashboard/content/repeaters/{slug}/entries', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesIndex')->name('dashboard.content.repeaters.entries');
        });

        Route::group(['middleware' => ['permission:create repeaters entry']], function () {
            Route::get('/dashboard/content/repeaters/{slug}/create', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesCreate')->name('dashboard.content.repeaters.entries.create');
            Route::post('/dashboard/content/repeaters/entries/save', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesSave')->name('dashboard.content.repeaters.entries.save');
        });

        Route::group(['middleware' => ['permission:edit repeaters entry']], function () {
            Route::get('/dashboard/content/repeaters/{slug}/edit/{id}', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesEdit')->name('dashboard.content.repeaters.entries.edit');
        });

        Route::group(['middleware' => ['permission:delete repeaters entry']], function () {
            Route::post('/dashboard/content/repeaters/entries/delete', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesDelete')->name('dashboard.content.repeaters.entries.delete');
        });
        //Route::post('/dashboard/content/repeaters/new', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterNew')->name('dashboard.content.resources.new');
		
    // Dashboard Users Routes...
        Route::group(['middleware' => ['permission:show users']], function () {
            Route::get('/dashboard/users', 'Chuckbe\Chuckcms\Controllers\UserController@index')->name('dashboard.users');
        });

        Route::group(['middleware' => ['permission:create users']], function () {
            Route::post('/dashboard/user/invite', 'Chuckbe\Chuckcms\Controllers\UserController@invite')->name('dashboard.users.invite');
            Route::post('/dashboard/user/save', 'Chuckbe\Chuckcms\Controllers\UserController@save')->name('dashboard.users.save');
        });

        Route::group(['middleware' => ['permission:edit users']], function () {
            Route::post('/dashboard/user/resend-invation', 'Chuckbe\Chuckcms\Controllers\UserController@resendInvitation')->name('dashboard.user.resend.invitation');
            Route::get('/dashboard/users/edit/{user}', 'Chuckbe\Chuckcms\Controllers\UserController@edit')->name('dashboard.users.edit');
        });
        
		Route::group(['middleware' => ['permission:delete users']], function () {
            Route::post('/dashboard/user/delete', 'Chuckbe\Chuckcms\Controllers\UserController@delete')->name('dashboard.user.delete');
        });
    // Dashboard Roles Routes...
        Route::group(['middleware' => ['permission:show roles']], function () {
            Route::get('/dashboard/users/roles', 'Chuckbe\Chuckcms\Controllers\UserRoleController@index')->name('dashboard.users.roles');
        });

        Route::group(['middleware' => ['permission:create roles']], function () {
            Route::post('/dashboard/users/role/create', 'Chuckbe\Chuckcms\Controllers\UserRoleController@create')->name('dashboard.users.roles.create');
        });

        Route::group(['middleware' => ['permission:edit roles']], function () {
            Route::get('/dashboard/users/role/edit/{role}', 'Chuckbe\Chuckcms\Controllers\UserRoleController@edit')->name('dashboard.users.roles.edit');
            Route::post('/dashboard/users/role/save', 'Chuckbe\Chuckcms\Controllers\UserRoleController@save')->name('dashboard.users.roles.save');
        });
        
        Route::group(['middleware' => ['permission:delete roles']], function () {
            Route::post('/dashboard/users/role/delete', 'Chuckbe\Chuckcms\Controllers\UserRoleController@delete')->name('dashboard.users.roles.delete');
        });

    // Dashboard Settings / Sites Routes...
        Route::group(['middleware' => ['permission:show settings']], function () {
            Route::get('/dashboard/settings', 'Chuckbe\Chuckcms\Controllers\DashboardController@settings')->name('dashboard.settings');
            Route::get('/dashboard/matomo', 'Chuckbe\Chuckcms\Controllers\MatomoController@index')->name('dashboard.matomo');
            Route::post('/dashboard/matomo/changerange', 'Chuckbe\Chuckcms\Controllers\MatomoController@matomo');
            Route::get('/dashboard/matomo/livevisit', 'Chuckbe\Chuckcms\Controllers\MatomoController@counter')->name('dashboard.livevisits');
            Route::post('/dashboard/matomo/submitmatomo', 'Chuckbe\Chuckcms\Controllers\MatomoController@submit')->name('dashboard.matomosubmit');
            Route::post('/dashboard/matomo/api', 'Chuckbe\Chuckcms\Controllers\MatomoController@ReportingApi')->name('dashboard.api');

            Route::get('/reportingApi', 'Chuckbe\Chuckcms\Controllers\MatomoController@ReportingApi');
            Route::get('/reportingApi/livecounter', 'Chuckbe\Chuckcms\Controllers\MatomoController@Livecounter');
            Route::post('/reportingApi/visitorsummary', 'Chuckbe\Chuckcms\Controllers\MatomoController@visitorsummary');
        });

        Route::group(['middleware' => ['permission:edit settings']], function () {
            Route::post('/dashboard/settings/save', 'Chuckbe\Chuckcms\Controllers\SiteController@save')->name('dashboard.settings.save');
        });
    });
    Route::get('/activate/user/{token}', 'Chuckbe\Chuckcms\Controllers\UserController@activateIndex')->name('activate.user.index');
    Route::post('/activate/user', 'Chuckbe\Chuckcms\Controllers\UserController@activate')->name('activate.user');

    Route::post('/forms/validate', 'Chuckbe\Chuckcms\Controllers\FormController@postForm')->name('forms.validate');
});

$middleware = array_merge(\Config::get('lfm.middlewares'), [
    '\UniSharp\LaravelFilemanager\Middlewares\MultiUser',
    '\UniSharp\LaravelFilemanager\Middlewares\CreateDefaultFolder',
]);
$prefix = \Config::get('lfm.url_prefix', \Config::get('lfm.prefix', 'laravel-filemanager'));
$as = 'unisharp.lfm.';
$namespace = '\UniSharp\LaravelFilemanager\Controllers';

// Routes for Package : Laravel Filemanager
Route::group(compact('middleware', 'prefix', 'as', 'namespace'), function() {

    // Show LFM
    Route::get('/', [
        'uses' => 'LfmController@show',
        'as' => 'show',
    ]);

    // Show integration error messages
    Route::get('/errors', [
        'uses' => 'LfmController@getErrors',
        'as' => 'getErrors',
    ]);

    // upload
    Route::any('/upload', [
        'uses' => 'UploadController@upload',
        'as' => 'upload',
    ]);

    // list images & files
    Route::get('/jsonitems', [
        'uses' => 'ItemsController@getItems',
        'as' => 'getItems',
    ]);

    // folders
    Route::get('/newfolder', [
        'uses' => 'FolderController@getAddfolder',
        'as' => 'getAddfolder',
    ]);
    Route::get('/deletefolder', [
        'uses' => 'FolderController@getDeletefolder',
        'as' => 'getDeletefolder',
    ]);
    Route::get('/folders', [
        'uses' => 'FolderController@getFolders',
        'as' => 'getFolders',
    ]);

    // crop
    Route::get('/crop', [
        'uses' => 'CropController@getCrop',
        'as' => 'getCrop',
    ]);
    Route::get('/cropimage', [
        'uses' => 'CropController@getCropimage',
        'as' => 'getCropimage',
    ]);
    Route::get('/cropnewimage', [
        'uses' => 'CropController@getNewCropimage',
        'as' => 'getCropimage',
    ]);

    // rename
    Route::get('/rename', [
        'uses' => 'RenameController@getRename',
        'as' => 'getRename',
    ]);

    // scale/resize
    Route::get('/resize', [
        'uses' => 'ResizeController@getResize',
        'as' => 'getResize',
    ]);
    Route::get('/doresize', [
        'uses' => 'ResizeController@performResize',
        'as' => 'performResize',
    ]);

    // download
    Route::get('/download', [
        'uses' => 'DownloadController@getDownload',
        'as' => 'getDownload',
    ]);

    // delete
    Route::get('/delete', [
        'uses' => 'DeleteController@getDelete',
        'as' => 'getDelete',
    ]);

});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 
            'Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect', 
            'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter', 
            'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath', 
            'web'
            ]
    ], function() {
    Route::any('/{slug?}', 'Chuckbe\Chuckcms\Controllers\FrontEndController@index')->where('slug', '(.*)')->name('page')->fallback();
});





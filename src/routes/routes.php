<?php

Route::group(['middleware' => ['web']], function() {
// Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController@logout']);

// Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController@register']);

// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Chuckbe\Chuckcms\Controllers\Auth\ResetPasswordController@reset']);
});

Route::group(['middleware' => ['web']], function() {
	Route::group(['middleware' => 'auth'], function () {
	// Dashboard Routes...
		Route::get('/dashboard', 'Chuckbe\Chuckcms\Controllers\DashboardController@index')->name('dashboard');
	// Dashboard Pages Routes...
		Route::group(['middleware' => ['permission:show pages']], function () {
		    Route::get('/dashboard/pages', 'Chuckbe\Chuckcms\Controllers\DashboardController@pages')->name('dashboard.pages');
		});
		Route::group(['middleware' => ['permission:create pages']], function () {
		    Route::get('/dashboard/page/create', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageCreate')->name('dashboard.page.create');
		    Route::post('/dashboard/page/save', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageSave')->name('dashboard.page.save');
		});
		
		Route::group(['middleware' => ['permission:edit pages']], function () {
			Route::get('/dashboard/page/{page_id}-edit', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEdit')->name('dashboard.page.edit');
		});
	// Dashboard Page Builder Routes...
		Route::group(['middleware' => ['permission:show pagebuilder']], function () {
			Route::get('/dashboard/page/{page_id}-edit/builder', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEditBuilder')->name('dashboard.page.edit.pagebuilder');
			Route::get('/dashboard/page/{page_id}/raw', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageRaw')->name('dashboard.page.raw');    
		});

		Route::group(['middleware' => ['permission:edit pagebuilder']], function () {
			Route::post('/pageblock/show', 'Chuckbe\Chuckcms\Controllers\PageBlockController@show')->name('api.pageblock.show');
			Route::post('/pageblock/update', 'Chuckbe\Chuckcms\Controllers\PageBlockController@update')->name('api.pageblock.update');
			Route::post('/pageblock/move-up', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveUp')->name('api.pageblock.move_up');
			Route::post('/pageblock/move-down', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveDown')->name('api.pageblock.move_down');
			Route::post('/pageblock/add-block-top', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockTop')->name('api.pageblock.add_block_top');
			Route::post('/pageblock/add-block-bottom', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockBottom')->name('api.pageblock.add_block_bottom');
		});
		
		Route::group(['middleware' => ['permission:show pagebuilder']], function () {
			Route::get('/dashboard/page/{page_id}-edit/builder', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEditBuilder')->name('dashboard.page.edit.pagebuilder');
			Route::get('/dashboard/page/{page_id}/raw', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageRaw')->name('dashboard.page.raw');    
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
		
		
	// Dashboard Templates Routes...
		Route::group(['middleware' => ['permission:show templates']], function () {
			Route::get('/dashboard/templates', 'Chuckbe\Chuckcms\Controllers\TemplateController@index')->name('dashboard.templates');
		});
		
	// Dashboard Forms Routes...
		Route::group(['middleware' => ['permission:show forms']], function () {
			Route::get('/dashboard/forms', 'Chuckbe\Chuckcms\Controllers\FormController@index')->name('dashboard.forms');
		});

		Route::group(['middleware' => ['permission:create forms']], function () {
			Route::get('/dashboard/forms/create', 'Chuckbe\Chuckcms\Controllers\FormController@create')->name('dashboard.forms.create');
			Route::post('/dashboard/forms/save', 'Chuckbe\Chuckcms\Controllers\FormController@save')->name('dashboard.forms.save');
		});
		
		Route::group(['middleware' => ['permission:edit forms']], function () {
			Route::get('/dashboard/forms/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\FormController@edit')->name('dashboard.forms.edit');
		});

		Route::group(['middleware' => ['permission:delete forms']], function () {
			Route::get('/dashboard/forms/{slug}/delete', 'Chuckbe\Chuckcms\Controllers\FormController@delete')->name('dashboard.forms.delete');
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
			
		});
		
	// Dashboard Content Repeaters Routes...		
		Route::group(['middleware' => ['permission:show repeaters']], function () {
			Route::get('/dashboard/content/repeaters', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterIndex')->name('dashboard.content.repeaters');
		});

		Route::group(['middleware' => ['permission:create repeaters']], function () {
			Route::get('/dashboard/content/repeaters/create', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterCreate')->name('dashboard.content.repeaters.create');
			Route::post('/dashboard/content/repeaters/save', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterSave')->name('dashboard.content.repeaters.save');
		});

		Route::group(['middleware' => ['permission:edit repeaters']], function () {
			Route::get('/dashboard/content/repeaters/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEdit')->name('dashboard.content.repeaters.edit');
		});

		Route::group(['middleware' => ['permission:delete repeaters']], function () {
			
		});
	// Dashboard Content Repeaters Entries Routes...
		Route::group(['middleware' => ['permission:show repeaters entries']], function () {
			Route::get('/dashboard/content/repeaters/{slug}/entries', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesIndex')->name('dashboard.content.repeaters.entries');
		});

		Route::group(['middleware' => ['permission:create repeaters entry']], function () {
			
		});

		Route::group(['middleware' => ['permission:edit repeaters entry']], function () {
			
		});

		Route::group(['middleware' => ['permission:delete repeaters entry']], function () {
			
		});
		//Route::post('/dashboard/content/repeaters/new', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterNew')->name('dashboard.content.resources.new');
		
	// Dashboard Users Routes...
		Route::group(['middleware' => ['permission:show users']], function () {
			Route::get('/dashboard/users', 'Chuckbe\Chuckcms\Controllers\DashboardController@users')->name('dashboard.users');
		});

		Route::group(['middleware' => ['permission:invite users']], function () {
			Route::post('/dashboard/user/invite', 'Chuckbe\Chuckcms\Controllers\UserController@invite')->name('dashboard.users.invite');
		});
		
		
	// Dashboard Settings / Sites Routes...
		Route::group(['middleware' => ['permission:show settings']], function () {
			Route::get('/dashboard/settings', 'Chuckbe\Chuckcms\Controllers\DashboardController@settings')->name('dashboard.settings');
		});

		Route::group(['middleware' => ['permission:edit settings']], function () {
			Route::post('/dashboard/settings/save', 'Chuckbe\Chuckcms\Controllers\SiteController@save')->name('dashboard.settings.save');
		});
	});
	Route::get('/activate/user/{token}', 'Chuckbe\Chuckcms\Controllers\UserController@activateIndex')->name('activate.user.index');
	Route::post('/activate/user', 'Chuckbe\Chuckcms\Controllers\UserController@activate')->name('activate.user');

	Route::post('/forms/validate', 'Chuckbe\Chuckcms\Controllers\FormController@postForm')->name('forms.validate');
});

Route::group([
	'prefix' => LaravelLocalization::setLocale(),
   	'middleware' => [ 
   		'Mcamara\LaravelLocalization\Middleware\localeSessionRedirect', 
   		'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter', 
   		'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath', 
   		'web' 
   		]
    ], function() {
	Route::get('/{slug?}', 'Chuckbe\Chuckcms\Controllers\PageController@index')->where('slug', '(.*)')->name('page');
});





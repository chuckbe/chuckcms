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
		Route::get('/dashboard/pages', 'Chuckbe\Chuckcms\Controllers\DashboardController@pages')->name('dashboard.pages');
		Route::group(['middleware' => ['permission:create pages']], function () {
		    Route::get('/dashboard/page/create', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageCreate')->name('dashboard.page.create');
		    Route::post('/dashboard/page/save', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageSave')->name('dashboard.page.save');
		});
		
		Route::group(['middleware' => ['permission:edit pages']], function () {
			Route::get('/dashboard/page/{page_id}-edit', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEdit')->name('dashboard.page.edit');
		});
	// Dashboard Page Builder Routes...
		Route::get('/dashboard/page/{page_id}-edit/builder', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEditBuilder')->name('dashboard.page.edit.pagebuilder');
		Route::get('/dashboard/page/{page_id}/raw', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageRaw')->name('dashboard.page.raw');
		Route::post('/pageblock/show', 'Chuckbe\Chuckcms\Controllers\PageBlockController@show')->name('api.pageblock.show');
		Route::post('/pageblock/update', 'Chuckbe\Chuckcms\Controllers\PageBlockController@update')->name('api.pageblock.update');
		Route::post('/pageblock/move-up', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveUp')->name('api.pageblock.move_up');
		Route::post('/pageblock/move-down', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveDown')->name('api.pageblock.move_down');
		Route::post('/pageblock/add-block-top', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockTop')->name('api.pageblock.add_block_top');
		Route::post('/pageblock/add-block-bottom', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockBottom')->name('api.pageblock.add_block_bottom');
		Route::post('/pageblock/delete', 'Chuckbe\Chuckcms\Controllers\PageBlockController@delete')->name('api.pageblock.delete');
	// Dashboard Menus Routes...
		Route::get('/dashboard/menus', 'Chuckbe\Chuckcms\Controllers\DashboardController@menus')->name('dashboard.menus');
		$path = rtrim(config('menu.route_path'));
	    Route::post($path . '/addcustommenu', array('as' => 'haddcustommenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@addcustommenu'));
	    Route::post($path . '/deleteitemmenu', array('as' => 'hdeleteitemmenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@deleteitemmenu'));
	    Route::post($path . '/deletemenug', array('as' => 'hdeletemenug', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@deletemenug'));
	    Route::post($path . '/createnewmenu', array('as' => 'hcreatenewmenu', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@createnewmenu'));
	    Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratemenucontrol', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@generatemenucontrol'));
	    Route::post($path . '/updateitem', array('as' => 'hupdateitem', 'uses' => 'Chuckbe\Chuckcms\Controllers\MenuController@updateitem'));
	// Dashboard Templates Routes...
		Route::get('/dashboard/templates', 'Chuckbe\Chuckcms\Controllers\DashboardController@templates')->name('dashboard.templates');
	// Dashboard Forms Routes...
		Route::get('/dashboard/forms', 'Chuckbe\Chuckcms\Controllers\FormController@index')->name('dashboard.forms');
		Route::get('/dashboard/forms/create', 'Chuckbe\Chuckcms\Controllers\FormController@create')->name('dashboard.forms.create');
		Route::get('/dashboard/forms/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\FormController@edit')->name('dashboard.forms.edit');
		Route::get('/dashboard/forms/{slug}/entries', 'Chuckbe\Chuckcms\Controllers\FormController@entries')->name('dashboard.forms.entries');
		Route::get('/dashboard/forms/{slug}/entry/{id}', 'Chuckbe\Chuckcms\Controllers\FormController@entry')->name('dashboard.forms.entry');
		Route::get('/dashboard/forms/{slug}/delete', 'Chuckbe\Chuckcms\Controllers\FormController@delete')->name('dashboard.forms.delete');
		Route::post('/dashboard/forms/save', 'Chuckbe\Chuckcms\Controllers\FormController@save')->name('dashboard.forms.save');
	// Dashboard Content Routes...
		Route::get('/dashboard/content/resources', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceIndex')->name('dashboard.content.resources');
		Route::get('/dashboard/content/resources/create', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceCreate')->name('dashboard.content.resources.create');
		Route::get('/dashboard/content/resources/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceEdit')->name('dashboard.content.resources.edit');
		Route::post('/dashboard/content/resources/save', 'Chuckbe\Chuckcms\Controllers\ContentController@resourceSave')->name('dashboard.content.resources.save');

		Route::get('/dashboard/content/repeaters', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterIndex')->name('dashboard.content.repeaters');
		Route::get('/dashboard/content/repeaters/create', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterCreate')->name('dashboard.content.repeaters.create');
		//Route::post('/dashboard/content/repeaters/new', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterNew')->name('dashboard.content.resources.new');
		Route::post('/dashboard/content/repeaters/save', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterSave')->name('dashboard.content.repeaters.save');
		Route::get('/dashboard/content/repeaters/{slug}/edit', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEdit')->name('dashboard.content.repeaters.edit');
		Route::get('/dashboard/content/repeaters/{slug}/entries', 'Chuckbe\Chuckcms\Controllers\ContentController@repeaterEntriesIndex')->name('dashboard.content.repeaters.entries');

	// Dashboard Users Routes...
		Route::get('/dashboard/users', 'Chuckbe\Chuckcms\Controllers\DashboardController@users')->name('dashboard.users');
		Route::post('/dashboard/user/invite', 'Chuckbe\Chuckcms\Controllers\UserController@invite')->name('dashboard.users.invite');
	// Dashboard Settings Routes...
		Route::get('/dashboard/settings', 'Chuckbe\Chuckcms\Controllers\DashboardController@settings')->name('dashboard.settings');
		Route::post('/dashboard/settings/save', 'Chuckbe\Chuckcms\Controllers\SiteController@save')->name('dashboard.settings.save');
	});
	Route::get('/activate/user/{token}', 'Chuckbe\Chuckcms\Controllers\UserController@activateIndex')->name('activate.user.index');
	Route::post('/activate/user', 'Chuckbe\Chuckcms\Controllers\UserController@activate')->name('activate.user');

	Route::post('/forms/validate', 'Chuckbe\Chuckcms\Controllers\FormController@postForm')->name('forms.validate');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'Mcamara\LaravelLocalization\Middleware\localeSessionRedirect', 'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter', 'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath', 'web' ]
    ],
    function()
    {

		Route::get('/{slug?}', 'Chuckbe\Chuckcms\Controllers\PageController@index')->where('slug', '(.*)')->name('page');

});





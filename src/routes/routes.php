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
		Route::get('/dashboard/page/create', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageCreate')->name('dashboard.page.create');
		Route::post('/dashboard/page/save', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageSave')->name('dashboard.page.save');
		Route::get('/dashboard/page/{page_id}-edit', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEdit')->name('dashboard.page.edit');
	// Dashboard Page Builder Routes...
		Route::get('/dashboard/page/{page_id}-edit/builder', 'Chuckbe\Chuckcms\Controllers\DashboardController@pageEditBuilder')->name('dashboard.page.edit.pagebuilder');
		Route::get('/dashboard/page/add_block', 'Chuckbe\Chuckcms\Controllers\PageBlockController@addBlockTop')->name('dashboard.page.add_block.pagebuilder');
		Route::post('/pageblock/show', 'Chuckbe\Chuckcms\Controllers\PageBlockController@show')->name('api.pageblock.show');
		Route::post('/pageblock/update', 'Chuckbe\Chuckcms\Controllers\PageBlockController@update')->name('api.pageblock.update');
		Route::post('/pageblock/move-up', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveUp')->name('api.pageblock.move_up');
		Route::post('/pageblock/move-down', 'Chuckbe\Chuckcms\Controllers\PageBlockController@moveDown')->name('api.pageblock.move_down');
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
	// Dashboard Users Routes...
		Route::get('/dashboard/users', 'Chuckbe\Chuckcms\Controllers\DashboardController@users')->name('dashboard.users');
	// Dashboard Settings Routes...
		Route::get('/dashboard/settings', 'Chuckbe\Chuckcms\Controllers\DashboardController@settings')->name('dashboard.settings');
	});
});

Route::get('/{slug?}/{slugger?}', 'Chuckbe\Chuckcms\Controllers\PageController@index')->name('page');
<?php

return [
	
	'auth' => [
		'get_login' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\LoginController',
			'action' => 'showLoginForm'
		],
		'post_login' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\LoginController',
			'action' => 'login'
		],
		'post_logout' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\LoginController',
			'action' => 'logout'
		],
		'get_register' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\RegisterController',
			'action' => 'showRegistrationForm'
		],
		'post_register' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\RegisterController',
			'action' => 'register'
		],
		'get_password_reset' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\ForgotPasswordController',
			'action' => 'showLinkRequestForm'
		],
		'post_password_email' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\ForgotPasswordController',
			'action' => 'sendResetLinkEmail'
		],
		'get_password_reset_token' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\ForgotPasswordController',
			'action' => 'showResetForm'
		],
		'post_password_reset' => [
			'controller' => 'Chuckbe\ChuckcmsModuleEcommerce\Controllers\Auth\ForgotPasswordController',
			'action' => 'reset'
		],

	],

];
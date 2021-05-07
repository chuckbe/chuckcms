<?php

return [
	
    'auth' => [
        'get_login' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'showLoginForm'
        ],
        'post_login' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'login'
        ],
        'post_logout' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'logout'
        ],
        'get_register' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action' => 'showRegistrationForm'
        ],
        'post_register' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action' => 'register'
        ],
        'get_password_reset' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'showLinkRequestForm'
        ],
        'post_password_email' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'sendResetLinkEmail'
        ],
        'get_password_reset_token' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'showResetForm'
        ],
        'post_password_reset' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'reset'
        ],

    ],
    'analytics' => [
        'matomoURL' => 'https://analytics.chuck.be'
    ],

];
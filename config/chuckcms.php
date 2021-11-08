<?php

return [
	
    'auth' => [
        'get_login' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'showLoginForm',
            'active' => true
        ],
        'post_login' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'login',
            'active' => true
        ],
        'post_logout' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action' => 'logout',
            'active' => true
        ],
        'get_register' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action' => 'showRegistrationForm',
            'active' => true
        ],
        'post_register' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action' => 'register',
            'active' => true
        ],
        'get_password_reset' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'showLinkRequestForm',
            'active' => true
        ],
        'post_password_email' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'sendResetLinkEmail',
            'active' => true
        ],
        'get_password_reset_token' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'showResetForm',
            'active' => true
        ],
        'post_password_reset' => [
            'controller' => 'Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action' => 'reset',
            'active' => true
        ],

    ],

];
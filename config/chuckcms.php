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
        'seo_fields' => [
            [
                'name' => 'title',
                'type' => 'text'
            ],
            [
                'name' => 'description',
                'type' => 'text'
            ],
            [
                'name' => 'keywords',
                'type' => 'text'
            ],
            [
                'name' => 'og-url',
                'type' => 'text'
            ],
            [
                'name' => 'og-type',
                'type' => 'text'
            ],
            [
                'name' => 'og-title',
                'type' => 'text'
            ],
            [
                'name' => 'og-description',
                'type' => 'text'
            ],
            [
                'name' => 'og-site_name',
                'type' => 'text'
            ],
            [
                'name' => 'robots',
                'type' => 'text'
            ],
            [
                'name' => 'googlebots',
                'type' => 'text'
            ],
        ],

    ],

];
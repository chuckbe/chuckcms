<?php

return [

    'auth' => [
        'get_login' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action'     => 'showLoginForm',
            'active'     => true,
        ],
        'post_login' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action'     => 'login',
            'active'     => true,
        ],
        'post_logout' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\LoginController',
            'action'     => 'logout',
            'active'     => true,
        ],
        'get_register' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action'     => 'showRegistrationForm',
            'active'     => false,
        ],
        'post_register' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\RegisterController',
            'action'     => 'register',
            'active'     => false,
        ],
        'get_password_reset' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action'     => 'showLinkRequestForm',
            'active'     => true,
        ],
        'post_password_email' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action'     => 'sendResetLinkEmail',
            'active'     => true,
        ],
        'get_password_reset_token' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action'     => 'showResetForm',
            'active'     => true,
        ],
        'post_password_reset' => [
            'controller' => '\Chuckbe\Chuckcms\Controllers\Auth\ForgotPasswordController',
            'action'     => 'reset',
            'active'     => true,
        ],

    ],

    'permissions' => [
        'super-admin' => [
            'show pages',
            'create pages',
            'edit pages',
            'delete pages',

            'show pagebuilder',
            'edit pagebuilder',
            'code pagebuilder',
            'delete pagebuilder',

            // menus
            'show menus',
            'create menus',
            'edit menus',
            'delete menus',

            // templates
            'show templates',
            'create templates',
            'edit templates',
            'delete templates',

            // forms
            'show forms',
            'create forms',
            'edit forms',
            'delete forms',

            // form entries
            'show formentry',
            'show formentries',
            'create formentries',
            'edit formentries',
            'delete formentries',

            // media
            'show media',
            'create media',
            'edit media',
            'delete media',

            // user
            'show users',
            'create users',
            'edit users',
            'delete users',

            // roles
            'show roles',
            'create roles',
            'edit roles',
            'delete roles',

            // content
            'show content',
            'create content',
            'edit content',
            'delete content',

            // redirects
            'show redirects',
            'create redirects',
            'edit redirects',
            'delete redirects',

            // resource
            'show resource',
            'create resource',
            'edit resource',
            'delete resource',

            // repeaters
            'show repeaters',
            'create repeaters',
            'edit repeaters',
            'delete repeaters',

            'show repeaters entries',
            'create repeaters entry',
            'edit repeaters entry',
            'delete repeaters entry',

            // settings
            'show settings',
            'create settings',
            'edit settings',
            'delete settings',
        ],

        'administrator' => [
            'show pages',
            'create pages',
            'edit pages',
            'delete pages',
            'show pagebuilder',
            'edit pagebuilder',
            'delete pagebuilder',

            'show menus',
            'create menus',
            'edit menus',
            'delete menus',

            'show templates',
            'create templates',
            'edit templates',
            'delete templates',

            'show forms',
            'create forms',
            'edit forms',
            'delete forms',

            'show formentries',
            'show formentry',
            'create formentries',
            'edit formentries',
            'delete formentries',

            'show media',
            'create media',
            'edit media',
            'delete media',

            'show users',
            'create users',
            'edit users',
            'delete users',

            'show roles',

            'show content',
            'create content',
            'edit content',
            'delete content',

            'show resource',
            'create resource',
            'edit resource',
            'delete resource',

            'show repeaters',
            'create repeaters',
            'edit repeaters',
            'delete repeaters',

            'show repeaters entries',
            'create repeaters entry',
            'edit repeaters entry',
            'delete repeaters entry',

            'show settings',
            'create settings',
            'edit settings',
            'delete settings',

            'show redirects',
            'create redirects',
            'edit redirects',
            'delete redirects',
        ],

        'moderator' => [
            'show pages',
            'create pages',
            'edit pages',
            'show pagebuilder',

            'show menus',
            'create menus',
            'edit menus',

            'show templates',
            'create templates',
            'edit templates',

            'show forms',
            'create forms',
            'edit forms',

            'show formentries',
            'show formentry',

            'show media',
            'create media',
            'edit media',

            'show users',
            'create users',
            'edit users',

            'show content',
            'create content',
            'edit content',

            'show resource',
            'create resource',
            'edit resource',

            'show repeaters',
            'create repeaters',
            'edit repeaters',

            'show repeaters entries',
            'create repeaters entry',
            'edit repeaters entry',

            'show settings',

            'show redirects',
            'create redirects',
            'edit redirects',
        ],

        'user' => [
            'show pages',

            'show menus',

            'show templates',

            'show forms',

            'show formentry',

            'show formentries',

            'show media',

            'show users',

            'show content',

            'show resource',

            'show repeaters',

            'show repeaters entries',

            'show settings',

            'show redirects',
        ],
    ],

];

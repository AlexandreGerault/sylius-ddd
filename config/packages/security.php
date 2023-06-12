<?php

declare(strict_types=1);

use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
        'enable_authenticator_manager' => true,
        'providers' => [
            'sylius_admin_user_provider' => [
                'id' => 'sylius.admin_user_provider.email_or_name_based',
            ],
            'sylius_api_admin_user_provider' => [
                'id' => 'sylius.admin_user_provider.email_or_name_based',
            ],
            'sylius_shop_user_provider' => [
                'id' => 'sylius.shop_user_provider.email_or_name_based',
            ],
            'sylius_api_shop_user_provider' => [
                'id' => 'sylius.shop_user_provider.email_or_name_based',
            ],
        ],
        'password_hashers' => [
            UserInterface::class => 'argon2i',
        ],
        'firewalls' => [
            'admin' => [
                'switch_user' => true,
                'context' => 'admin',
                'pattern' => '%sylius.security.admin_regex%',
                'provider' => 'sylius_admin_user_provider',
                'form_login' => [
                    'provider' => 'sylius_admin_user_provider',
                    'login_path' => 'sylius_admin_login',
                    'check_path' => 'sylius_admin_login_check',
                    'failure_path' => 'sylius_admin_login',
                    'default_target_path' => 'sylius_admin_dashboard',
                    'use_forward' => false,
                    'use_referer' => true,
                    'enable_csrf' => true,
                    'csrf_parameter' => '_csrf_admin_security_token',
                    'csrf_token_id' => 'admin_authenticate',
                ],
                'remember_me' => [
                    'secret' => '%env(APP_SECRET)%',
                    'path' => '/%sylius_admin.path_name%',
                    'name' => 'APP_ADMIN_REMEMBER_ME',
                    'lifetime' => 31536000,
                    'remember_me_parameter' => '_remember_me',
                ],
                'logout' => [
                    'path' => 'sylius_admin_logout',
                    'target' => 'sylius_admin_login',
                ],
            ],
            'new_api_admin_user' => [
                'pattern' => '%sylius.security.new_api_admin_regex%/.*',
                'provider' => 'sylius_api_admin_user_provider',
                'stateless' => true,
                'entry_point' => 'jwt',
                'json_login' => [
                    'check_path' => '%sylius.security.new_api_admin_route%/authentication-token',
                    'username_path' => 'email',
                    'password_path' => 'password',
                    'success_handler' => 'lexik_jwt_authentication.handler.authentication_success',
                    'failure_handler' => 'lexik_jwt_authentication.handler.authentication_failure',
                ],
                'jwt' => true,
            ],
            'new_api_shop_user' => [
                'pattern' => '%sylius.security.new_api_shop_regex%/.*',
                'provider' => 'sylius_api_shop_user_provider',
                'stateless' => true,
                'entry_point' => 'jwt',
                'json_login' => [
                    'check_path' => '%sylius.security.new_api_shop_route%/authentication-token',
                    'username_path' => 'email',
                    'password_path' => 'password',
                    'success_handler' => 'lexik_jwt_authentication.handler.authentication_success',
                    'failure_handler' => 'lexik_jwt_authentication.handler.authentication_failure',
                ],
                'jwt' => true,
            ],
            'shop' => [
                'switch_user' => [
                    'role' => 'ROLE_ALLOWED_TO_SWITCH',
                ],
                'context' => 'shop',
                'pattern' => '%sylius.security.shop_regex%',
                'provider' => 'sylius_shop_user_provider',
                'form_login' => [
                    'success_handler' => 'sylius.authentication.success_handler',
                    'failure_handler' => 'sylius.authentication.failure_handler',
                    'provider' => 'sylius_shop_user_provider',
                    'login_path' => 'sylius_shop_login',
                    'check_path' => 'sylius_shop_login_check',
                    'failure_path' => 'sylius_shop_login',
                    'default_target_path' => 'sylius_shop_homepage',
                    'use_forward' => false,
                    'use_referer' => true,
                    'enable_csrf' => true,
                    'csrf_parameter' => '_csrf_shop_security_token',
                    'csrf_token_id' => 'shop_authenticate',
                ],
                'remember_me' => [
                    'secret' => '%env(APP_SECRET)%',
                    'name' => 'APP_SHOP_REMEMBER_ME',
                    'lifetime' => 31536000,
                    'remember_me_parameter' => '_remember_me',
                ],
                'logout' => [
                    'path' => 'sylius_shop_logout',
                    'target' => 'sylius_shop_homepage',
                    'invalidate_session' => false,
                ],
            ],
            'dev' => [
                'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
                'security' => false,
            ],
        ],
        'access_control' => [
            [
                'path' => '%sylius.security.admin_regex%/_partial',
                'role' => 'PUBLIC_ACCESS',
                'ips' => [
                    '127.0.0.1',
                    '::1',
                ],
            ],
            [
                'path' => '%sylius.security.admin_regex%/_partial',
                'role' => 'ROLE_NO_ACCESS',
            ],
            [
                'path' => '%sylius.security.shop_regex%/_partial',
                'role' => 'PUBLIC_ACCESS',
                'ips' => [
                    '127.0.0.1',
                    '::1',
                ],
            ],
            [
                'path' => '%sylius.security.shop_regex%/_partial',
                'role' => 'ROLE_NO_ACCESS',
            ],
            [
                'path' => '%sylius.security.admin_regex%/forgotten-password',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.admin_regex%/login',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.shop_regex%/login',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.shop_regex%/register',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.shop_regex%/verify',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.admin_regex%',
                'role' => 'ROLE_ADMINISTRATION_ACCESS',
            ],
            [
                'path' => '%sylius.security.shop_regex%/account',
                'role' => 'ROLE_USER',
            ],
            [
                'path' => '%sylius.security.new_api_admin_route%/reset-password-requests',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.new_api_admin_regex%/.*',
                'role' => 'ROLE_API_ACCESS',
            ],
            [
                'path' => '%sylius.security.new_api_admin_route%/authentication-token',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.new_api_user_account_regex%/.*',
                'role' => 'ROLE_USER',
            ],
            [
                'path' => '%sylius.security.new_api_shop_route%/authentication-token',
                'role' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '%sylius.security.new_api_shop_regex%/.*',
                'role' => 'PUBLIC_ACCESS',
            ],
        ],
    ]);
};

<?php

declare(strict_types=1);

use Sylius\PayPalPlugin\Form\Type\SelectPaymentType;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('@SyliusShopBundle/Resources/config/routing.yml')
        ->prefix('/{_locale}')
        ->requirements([
            '_locale' => '^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$',
        ]);

    $routingConfigurator->import('@SyliusShopBundle/Resources/config/routing/payum.yml');

    $routingConfigurator->add('sylius_shop_default_locale', '/')
        ->controller([
            'sylius.controller.shop.locale_switch',
            'switchAction',
        ])
        ->methods([
            'GET',
        ]);

    $routingConfigurator->import('@SyliusPayPalPlugin/Resources/config/shop_routing.yaml')
        ->prefix('/{_locale}')
        ->requirements([
            '_locale' => '^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$',
        ]);

    $routingConfigurator->add('sylius_shop_order_show', '/order/{tokenValue}')
        ->controller([
            'sylius.controller.order',
            'updateAction',
        ])
        ->defaults([
            '_sylius' => [
                'template' => '@SyliusShop/Order/show.html.twig',
                'repository' => [
                    'method' => 'findOneBy',
                    'arguments' => [
                        [
                            'tokenValue' => '$tokenValue',
                        ],
                    ],
                ],
                'form' => [
                    'type' => SelectPaymentType::class,
                    'options' => [
                        'validation_groups' => [
                            'sylius_order_pay',
                        ],
                    ],
                ],
                'redirect' => [
                    'route' => 'sylius_shop_order_pay',
                    'parameters' => [
                        'tokenValue' => 'resource.tokenValue',
                    ],
                ],
                'flash' => false,
            ],
        ])
        ->methods([
            'GET',
            'PUT',
        ]);

    $routingConfigurator->add('sylius_shop_request_password_reset_token_redirect', '/.well-known/change-password')
        ->controller('Symfony\Bundle\FrameworkBundle\Controller\RedirectController::redirectAction')
        ->defaults([
            'route' => 'sylius_shop_request_password_reset_token',
            'permanent' => false,
        ])
        ->methods([
            'GET',
        ]);
};

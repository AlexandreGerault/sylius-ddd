<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('@SyliusAdminBundle/Resources/config/routing.yml')
        ->prefix('/%sylius_admin.path_name%');

    $routingConfigurator->import('@SyliusPayPalPlugin/Resources/config/admin_routing.yml')
        ->prefix('/%sylius_admin.path_name%');
};

<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('@SyliusApiBundle/Resources/config/routing.yml')
        ->prefix('%sylius.security.new_api_route%');
};

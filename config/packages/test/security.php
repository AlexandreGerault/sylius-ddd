<?php

declare(strict_types=1);

use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
        'password_hashers' => [
            UserInterface::class => [
                'algorithm' => 'argon2i',
                'time_cost' => 3,
                'memory_cost' => 10,
            ],
        ],
    ]);
};

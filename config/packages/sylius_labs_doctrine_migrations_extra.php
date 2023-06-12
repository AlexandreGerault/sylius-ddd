<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('sylius_labs_doctrine_migrations_extra', [
        'migrations' => [
            'App\Migrations' => null,
        ],
    ]);
};

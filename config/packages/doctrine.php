<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('env(DATABASE_URL)', '');

    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'url' => '%env(resolve:DATABASE_URL)%',
        ],
        'orm' => [
            'auto_generate_proxy_classes' => '%kernel.debug%',
            'entity_managers' => [
                'default' => [
                    'auto_mapping' => true,
                    'mappings' => [
                        'Shared' => [
                            'is_bundle' => false,
                            'type' => 'attribute',
                            'dir' => '%kernel.project_dir%/src/Shared/Infrastructure/Entity',
                            'prefix' => 'App\Shared\Infrastructure\Entity',
                            'alias' => 'Shared',
                        ],
                    ],
                ],
            ],
        ],
    ]);
};

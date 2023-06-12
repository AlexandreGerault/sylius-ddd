<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('flysystem', [
        'storages' => [
            'sylius.storage' => [
                'adapter' => 'local',
                'options' => [
                    'directory' => '%sylius_core.images_dir%',
                ],
            ],
        ],
    ]);
};

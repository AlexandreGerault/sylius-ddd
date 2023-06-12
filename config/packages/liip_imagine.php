<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('liip_imagine', [
        'resolvers' => [
            'default' => [
                'web_path' => [
                    'web_root' => '%kernel.project_dir%/public',
                    'cache_prefix' => 'media/cache',
                ],
            ],
        ],
    ]);
};

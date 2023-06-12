<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/vendor/sylius/sylius/src/Sylius/Bundle/ApiBundle/Resources/config/api_resources',
                '%kernel.project_dir%/config/api_platform',
                '%kernel.project_dir%/src/Shared/Infrastructure/Entity',
            ],
        ],
        'patch_formats' => [
            'json' => [
                'application/merge-patch+json',
            ],
        ],
        'swagger' => [
            'versions' => [
                3,
            ],
        ],
    ]);
};

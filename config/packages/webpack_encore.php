<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('webpack_encore', [
        'output_path' => '%kernel.project_dir%/public/build/default',
        'builds' => [
            'admin' => '%kernel.project_dir%/public/build/admin',
            'shop' => '%kernel.project_dir%/public/build/shop',
            'app.admin' => '%kernel.project_dir%/public/build/app/admin',
            'app.shop' => '%kernel.project_dir%/public/build/app/shop',
        ],
    ]);
};

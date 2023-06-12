<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Twig\Extra\Intl\IntlExtension;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'paths' => [
            '%kernel.project_dir%/templates',
        ],
        'debug' => '%kernel.debug%',
        'strict_variables' => '%kernel.debug%',
    ]);

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(IntlExtension::class);
    if ($containerConfigurator->env() === 'test_cached') {
        $containerConfigurator->extension('twig', [
            'strict_variables' => true,
        ]);
    }
};

<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'mailer' => [
            'dsn' => '%env(MAILER_DSN)%',
        ],
    ]);
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('framework', [
            'cache' => [
                'pools' => [
                    'test.mailer_pool' => [
                        'adapter' => 'cache.adapter.filesystem',
                    ],
                ],
            ],
        ]);
    }
    if ($containerConfigurator->env() === 'test_cached') {
        $containerConfigurator->extension('framework', [
            'cache' => [
                'pools' => [
                    'test.mailer_pool' => [
                        'adapter' => 'cache.adapter.filesystem',
                    ],
                ],
            ],
        ]);
    }
};

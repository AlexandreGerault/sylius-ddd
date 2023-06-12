<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'translator' => [
            'fallbacks' => [
                '%locale%',
            ],
        ],
        'secret' => '%env(APP_SECRET)%',
        'form' => [
            'enabled' => true,
            'legacy_error_messages' => false,
        ],
        'csrf_protection' => true,
        'session' => [
            'handler_id' => null,
        ],
        'serializer' => [
            'mapping' => [
                'paths' => [
                    '%kernel.project_dir%/config/serialization',
                ],
            ],
        ],
    ]);
    if ($containerConfigurator->env() === 'dev') {
        $containerConfigurator->extension('framework', [
            'profiler' => [
                'only_exceptions' => false,
            ],
        ]);
    }
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('framework', [
            'test' => true,
            'session' => [
                'storage_factory_id' => 'session.storage.factory.mock_file',
            ],
        ]);
    }
    if ($containerConfigurator->env() === 'test_cached') {
        $containerConfigurator->extension('framework', [
            'test' => true,
            'session' => [
                'storage_factory_id' => 'session.storage.factory.mock_file',
            ],
        ]);
    }
};

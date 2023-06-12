<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('fos_rest', [
        'exception' => true,
        'view' => [
            'formats' => [
                'json' => true,
                'xml' => true,
            ],
            'empty_content' => 204,
        ],
        'format_listener' => [
            'rules' => [
                [
                    'path' => '^/api/v1/.*',
                    'priorities' => [
                        'json',
                        'xml',
                    ],
                    'fallback_format' => 'json',
                    'prefer_extension' => true,
                ],
                [
                    'path' => '^/',
                    'stop' => true,
                ],
            ],
        ],
    ]);
};

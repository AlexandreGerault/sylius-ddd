<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    if ($containerConfigurator->env() === 'dev') {
        $containerConfigurator->extension('web_profiler', [
            'toolbar' => true,
            'intercept_redirects' => false,
        ]);
    }
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('web_profiler', [
            'toolbar' => false,
            'intercept_redirects' => false,
        ]);
        $containerConfigurator->extension('framework', [
            'profiler' => [
                'collect' => false,
            ],
        ]);
    }
    if ($containerConfigurator->env() === 'test_cached') {
        $containerConfigurator->extension('web_profiler', [
            'toolbar' => false,
            'intercept_redirects' => false,
        ]);
        $containerConfigurator->extension('framework', [
            'profiler' => [
                'collect' => false,
            ],
        ]);
    }
};

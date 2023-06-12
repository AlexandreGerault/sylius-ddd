<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__.'/../vendor/sylius/sylius/src/Sylius/Behat/Resources/config/services.xml');

    $containerConfigurator->extension('sylius_api', [
        'enabled' => true,
    ]);
};

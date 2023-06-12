<?php

declare(strict_types=1);

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('locale', 'en_US');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->instanceof(ResourceController::class)
        ->autowire(false);

    $services->instanceof(AbstractResourceType::class)
        ->autowire(false);

    $services->load('App\\Shared\\', dirname(__DIR__, 1).'/src/Shared')
        ->exclude([
            dirname(__DIR__, 1).'/src/Shared/Infrastructure/Entity',
            dirname(__DIR__, 1).'/src/Shared/Infrastructure/Migrations',
            dirname(__DIR__, 1).'/src/Shared/Infrastructure/Symfony/Kernel.php',
        ]);
    /**
     * TODO: Remove as controllers should be defined in domains
     */
    //    $services->load('App\Controller\\', __DIR__ . '/../src/Controller')
    //        ->tag('controller.service_arguments');
};

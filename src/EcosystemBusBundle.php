<?php

namespace Ecosystem\BusBundle;

use Ecosystem\BusBundle\Service\ConsumerService;
use Ecosystem\BusBundle\Service\PublisherService;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class EcosystemBusBundle extends AbstractBundle
{
    public function loadExtension(
        array $config,
        ContainerConfigurator $containerConfigurator,
        ContainerBuilder $containerBuilder
    ): void {
        $containerConfigurator->import('../config/services.yaml');

        foreach ($config['queues'] as $name => $queueConfig) {
            $containerConfigurator->services()->get(ConsumerService::class)->call('addQueue', [
                $name,
                $queueConfig['url'],
                new Reference($queueConfig['handler'])
            ]);
        }

        $containerConfigurator->services()->get(PublisherService::class)->arg(0, $config['buses']);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }
}

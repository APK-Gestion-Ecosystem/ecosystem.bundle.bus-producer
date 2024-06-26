<?php

namespace Ecosystem\BusProducerBundle;

use Ecosystem\BusProducerBundle\Library\Processor\MessageProcessorInterface;
use Ecosystem\BusProducerBundle\Service\ProducerService;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class EcosystemBusProducerBundle extends AbstractBundle
{
    public function loadExtension(
        array $config,
        ContainerConfigurator $containerConfigurator,
        ContainerBuilder $containerBuilder
    ): void {
        $containerConfigurator->import('../config/services.yaml');

        foreach ($config['buses'] as $name => $busConfig) {
            $containerConfigurator->services()->get(ProducerService::class)->call('addBus', [$name, $busConfig['arn']]);
        }

        $containerBuilder->registerForAutoconfiguration(MessageProcessorInterface::class)->addTag('ecosystem.bus_producer.message_processor');
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }
}

<?php

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;

return static function (DefinitionConfigurator $definition) {
    $definition->rootNode()
        ->children()
            ->arrayNode('buses')
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('name')->end()
                    ->end()
                ->end()
            ->end() // buses
        ->end()
    ;
};

<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private const CONNECTION_TIMEOUT = 0;
    private const REQUEST_TIMEOUT = 0;

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('answear_getdressed_me');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('apiUrl')->end()
            ->scalarNode('token')->cannotBeEmpty()->end()
            ->scalarNode('storeId')->cannotBeEmpty()->end()
            ->floatNode('connectionTimeout')->defaultValue(self::CONNECTION_TIMEOUT)->end()
            ->floatNode('requestTimeout')->defaultValue(self::REQUEST_TIMEOUT)->end()
            ->end();

        return $treeBuilder;
    }
}

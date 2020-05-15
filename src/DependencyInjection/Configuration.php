<?php
/*
 * This file is part of the ideneal/io-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\IOBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ideneal\Bundle\IOBundle\DependencyInjection
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ideneal_io');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('ideneal_io');
        }

        $rootNode
            ->children()
                ->arrayNode('input')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('format_converters')->defaultTrue()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
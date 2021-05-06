<?php

/*
 * This file is part of the Mobizel package.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('mobizel_markdown_docs');
        $rootNode = $treeBuilder->getRootNode();

        $this->addContextsSection($rootNode);

        return $treeBuilder;
    }

    private function addContextsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('contexts')
                    ->useAttributeAsKey('name')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('path')->cannotBeEmpty()->end()
                                ->scalarNode('pattern')->end()
                                ->arrayNode('requirements')
                                    ->scalarPrototype()->end()
                                ->end()
                                ->arrayNode('metadata')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('title')->cannotBeEmpty()->defaultValue('Documentation')->end()
                                    ->end()
                                ->end()
                                ->scalarNode('docs_dir')->cannotBeEmpty()->end()
                            ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}

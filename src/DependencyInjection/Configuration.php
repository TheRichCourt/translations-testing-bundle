<?php

declare(strict_types=1);

namespace TheRichCourt\TranslationsTestingBundle\DependencyInjection;

use LogicException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('translations_testing');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->variableNode('locales')
                    ->defaultValue([])
                    ->info('Array of locales')
                    ->example('["en", "es", "fr"]')
                ->end()
            ->end()
            ->validate()
            ->iftrue(function (array $config): bool {
                if (empty($config['locales'])) {
                    return true;
                }

                foreach ($config['locales'] as $locale) {
                    if (!\is_scalar($locale)) {
                        return true;
                    }
                }

                return false;
            })
            ->then(function (array $config): array {
                if (empty($config['locales'])) {
                    throw new LogicException('`locales` configuration contains no values.');
                }

                foreach ($config['locales'] as $locale) {
                    if (!\is_scalar($locale)) {
                        throw new LogicException('`locales` configuration should only contain scalar values.');
                    }
                }

                return $config;
            })
            ->end()
        ;

        return $treeBuilder;
    }
}

<?php

declare(strict_types=1);

namespace Keboola\SnowflakeParametersExtractor;

use Keboola\Component\Config\BaseConfigDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ConfigDefinition extends BaseConfigDefinition
{
    protected function getParametersDefinition(): ArrayNodeDefinition
    {
        $parametersNode = parent::getParametersDefinition();
        // @formatter:off
        /** @noinspection NullPointerExceptionInspection */
        $parametersNode
            ->children()
                ->scalarNode('host')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('username')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('#password')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
        // @formatter:on
        return $parametersNode;
    }
}

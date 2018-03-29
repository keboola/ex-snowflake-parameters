<?php

namespace Keboola\SnowflakeParametersExtractor\Tests;

use PHPUnit\Framework\TestCase;
use Keboola\SnowflakeParametersExtractor\ConfigDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

class ConfigDefinitionTest extends TestCase
{
    /**
     * @dataProvider provideValidConfigs
     */
    public function testValidConfigDefinition(array $inputConfig, array $expectedConfig): void
    {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $processedConfig = $processor->processConfiguration($definition, [$inputConfig]);
        $this->assertSame($expectedConfig, $processedConfig);
    }

    /**
     * @return mixed[][]
     */
    public function provideValidConfigs(): array
    {
        return [
            'minimal config' => [
                [
                    'parameters' => [
                        'host' => 'kebooladev.snowflakecomputing.com',
                        'username' => 'test-user',
                        '#password' => 'secret',
                    ],
                ],
                [
                    'parameters' => [
                        'host' => 'kebooladev.snowflakecomputing.com',
                        'username' => 'test-user',
                        '#password' => 'secret',
                    ],
                ],
            ],
            'config with extra params' => [
                [
                    'parameters' => [
                        'host' => 'kebooladev.snowflakecomputing.com',
                        'username' => 'test-user',
                        '#password' => 'secret',
                        'other' => 'something',
                    ],
                ],
                [
                    'parameters' => [
                        'host' => 'kebooladev.snowflakecomputing.com',
                        'username' => 'test-user',
                        '#password' => 'secret',
                        'other' => 'something',
                    ],
                ],
            ],
        ];
    }

    /**
    * @dataProvider provideInvalidConfigs
    */
    public function testInvalidConfigDefinition(
        array $inputConfig,
        string $expectedExceptionClass,
        string $expectedExceptionMessage
    ): void {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $this->expectException($expectedExceptionClass);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $processor->processConfiguration($definition, [$inputConfig]);
    }

    /**
     * @return mixed[][]
     */
    public function provideInvalidConfigs(): array
    {
        return [
            'empty parameters' => [
                [
                    'parameters' => [],
                ],
                InvalidConfigurationException::class,
                'The child node "host" at path "root.parameters" must be configured.',
            ],
            'missing password base' => [
                [
                    'parameters' => [
                        'host' => 'kebooladev.snowflakecomputing.com',
                        'username' => 'test-user',
                    ],
                ],
                InvalidConfigurationException::class,
                'The child node "#password" at path "root.parameters" must be configured.',
            ],
        ];
    }
}

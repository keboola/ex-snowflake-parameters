<?php

declare(strict_types=1);

namespace Keboola\SnowflakeParametersExtractor;

use Keboola\Component\BaseComponent;
use Keboola\Component\UserException;
use Keboola\Csv\CsvFile;
use Keboola\Db\Import\Exception as SnowflakeException;
use Keboola\Db\Import\Snowflake\Connection;

class Component extends BaseComponent
{
    public function run(): void
    {
        $parametersFetcher = new ParametersFetcher($this->createSnowflakeConnection());
        $parameters = $this->addHostToParameters(
            $parametersFetcher->fetchAccountParameters()
        );

        $csvFile = new CsvFile($this->getAccountParametersTableDestination());
        foreach ($parameters as $parameter) {
            $csvFile->writeRow($parameter);
        }

        $this->getManifestManager()->writeTableManifestFromArray(
            $this->getAccountParametersTableDestination(),
            [
                'primary_key' => [
                    'host',
                    'key',
                ],
                'columns' => array_keys($parameters[0]),
            ]
        );
    }

    private function addHostToParameters(array $parameters): array
    {
        /** @var Config $config */
        $config = $this->getConfig();
        return array_map(
            function(array $parameter) use ($config) {
                return array_merge(
                    [
                        'host' => $config->getHost(),
                    ],
                    $parameter
                );
            },
            $parameters
        );
    }

    private function createSnowflakeConnection(): Connection
    {
        /** @var Config $config */
        $config = $this->getConfig();
        try {
            return new Connection([
                'host' => $config->getHost(),
                'user' => $config->getUsername(),
                'password' => $config->getPassword(),
            ]);
        } catch (SnowflakeException $e) {
            throw new UserException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getAccountParametersTableDestination(): string
    {
        return $this->getDataDir()  . '/out/tables/account-parameters.csv';
    }

    protected function getConfigClass(): string
    {
        return Config::class;
    }

    protected function getConfigDefinitionClass(): string
    {
        return ConfigDefinition::class;
    }
}

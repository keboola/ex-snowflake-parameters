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
        $parameters = $parametersFetcher->fetchAccountParameters();

        $csvFile = new CsvFile($this->getAccountParametersTableDestination());
        $csvFile->writeRow(array_keys($parameters[0]));
        foreach ($parameters as $parameter) {
            $csvFile->writeRow($parameter);
        }
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

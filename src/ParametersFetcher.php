<?php


namespace Keboola\SnowflakeParametersExtractor;

use Keboola\Db\Import\Snowflake\Connection;

class ParametersFetcher
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAccountParameters(): array
    {
        return $this->connection->fetchAll("SHOW PARAMETERS IN ACCOUNT");
    }
}

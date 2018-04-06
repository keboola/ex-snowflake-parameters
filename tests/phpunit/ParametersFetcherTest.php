<?php

declare(strict_types=1);

namespace Keboola\SnowflakeParametersExtractor\Tests;

use Keboola\Db\Import\Snowflake\Connection;
use Keboola\SnowflakeParametersExtractor\ParametersFetcher;
use PHPUnit\Framework\TestCase;

class ParametersFetcherTest extends TestCase
{

    public function testFetchParameters(): void
    {
        $connection = new Connection([
            'host' => getenv('SNOWFLAKE_HOST'),
            'user' => getenv('SNOWFLAKE_USER'),
            'password' => getenv('SNOWFLAKE_PASSWORD'),
        ]);

        $accountParameters = (new ParametersFetcher($connection))->fetchAccountParameters();
        $firstParameter = reset($accountParameters);

        $this->assertNotEmpty($accountParameters);

        $this->assertArrayHasKey('key', $firstParameter);
        $this->assertArrayHasKey('value', $firstParameter);
        $this->assertArrayHasKey('default', $firstParameter);
        $this->assertArrayHasKey('level', $firstParameter);
        $this->assertArrayHasKey('description', $firstParameter);
    }
}

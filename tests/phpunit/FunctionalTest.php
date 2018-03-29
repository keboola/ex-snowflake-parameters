<?php

declare(strict_types=1);

namespace Keboola\SnowflakeParametersExtractor\Tests;

use Keboola\Temp\Temp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class FunctionalTest extends TestCase
{
    /**
     * @var Temp
     */
    private $temp;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->temp = new Temp("component");
        $this->temp->initRunFolder();
    }

    public function testSuccessfulRun()
    {
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($this->temp->getTmpFolder() . '/out/tables');
        $fileSystem->dumpFile(
            $this->temp->getTmpFolder() . '/config.json',
            \json_encode([
                'parameters' => [
                    'host' => getenv('SNOWFLAKE_HOST'),
                    'username' => getenv('SNOWFLAKE_USER'),
                    '#password' => getenv('SNOWFLAKE_PASSWORD'),
                ],
            ])
        );

        $runCommand = "KBC_DATADIR={$this->temp->getTmpFolder()} php /code/src/run.php";
        $runProcess = new  Process($runCommand);
        $runProcess->mustRun();

        $this->assertFileExists($this->temp->getTmpFolder() . '/out/tables/account-parameters.csv');
    }
}

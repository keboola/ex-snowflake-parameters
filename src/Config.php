<?php

declare(strict_types=1);

namespace Keboola\SnowflakeParametersExtractor;

use Keboola\Component\Config\BaseConfig;

class Config extends BaseConfig
{
    public function getHost(): string
    {
        return $this->getValue(['parameters', 'host']);
    }

    public function getUsername(): string
    {
        return $this->getValue(['parameters', 'username']);
    }

    public function getPassword(): string
    {
        return $this->getValue(['parameters', '#password']);
    }
}

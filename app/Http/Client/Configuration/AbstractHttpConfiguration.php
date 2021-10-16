<?php

namespace App\Http\Client\Configuration;

/**
 * Class AbstractConfiguration
 * @package App\DataProvider
 */
abstract class AbstractHttpConfiguration implements HttpConfigurationInterface
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var array
     */
    protected $credentials;

    /**
     * @return mixed
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     *
     * @return AbstractHttpConfiguration
     */
    public function setHost(string $host): HttpConfigurationInterface
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCredentials(): ?array
    {
        return $this->credentials;
    }

    /**
     * @param mixed $credentials
     *
     * @return HttpConfigurationInterface
     */
    public function setCredentials(array $credentials): HttpConfigurationInterface
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return static
     */
    abstract public static function init(): HttpConfigurationInterface;
}

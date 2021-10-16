<?php

namespace App\Http\Client\Configuration;

/**
 * Interface ConfigurationInterface
 * @package App\DataProvider
 */
interface HttpConfigurationInterface
{
    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return array|null
     */
    public function getCredentials(): ?array;

    /**
     * @param string $host
     *
     * @return HttpConfigurationInterface
     */
    public function setHost(string $host): self;

    /**
     * @param array $credentials
     *
     * @return HttpConfigurationInterface
     */
    public function setCredentials(array $credentials): self;
}

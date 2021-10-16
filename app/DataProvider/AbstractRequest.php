<?php

namespace App\DataProvider;

use App\Http\Client\Configuration\HttpConfigurationInterface;
use App\Http\Client\Request\HttpRequest;
use App\Http\Client\Request\HttpRequestInterface;

/**
 * Class AbstractRequest
 * @package App\DataProvider
 */
abstract class AbstractRequest implements DataProviderApiInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var HttpConfigurationInterface
     */
    protected $config;

    /**
     * @var DataProviderEntityInterface
     */
    protected $providerEntity;

    /**
     * @var array
     */
    protected $body;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @return DataProviderEntityInterface
     */
    public function getProviderEntity(): DataProviderEntityInterface
    {
        return $this->providerEntity;
    }

    /**
     * @param DataProviderEntityInterface $providerEntity
     *
     * @return AbstractRequest
     */
    public function setProviderEntity(DataProviderEntityInterface $providerEntity): DataProviderApiInterface
    {
        $this->providerEntity = $providerEntity;

        return $this;
    }

    /**
     * @return HttpRequestInterface
     */
    protected function buildRequest(): HttpRequestInterface
    {
        $request = new HttpRequest();
        $request->setConfiguration($this->config);
        $request->setMethod($this->method);
        $request->setPath($this->path);

        if ('json' === $this->contentType) {
            $request->setHeaders([
                'Content-Type' => 'application/json'
            ]);
            $request->setJson($this->body);
        }

        return $request;
    }

    abstract public function handler();
}

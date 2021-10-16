<?php

namespace App\Http\Client\Request;

use App\Exceptions\DataProviderException;
use App\Http\Client\Client;
use App\Http\Client\Configuration\HttpConfigurationInterface;
use App\Http\Client\Response\HttpResponseInterface;

final class HttpRequest implements HttpRequestInterface
{
    /** @var string $method HTTP method */
    private $method = 'GET';

    /** @var string $protocol http/https */
    private $protocol = 'https';

    /** @var string $host */
    private $host;

    /** @var integer $port */
    private $port = 80;

    /** @var string $path to url */
    private $path;

    /** @var array $headers */
    private $headers = [];

    /** @var string $token */
    private $token;

    /** @var array $options */
    private $options = [];

    /** @var array $body */
    private $body = [];

    /**@var array $json */
    private $json = [];

    /**
     * @var HttpConfigurationInterface
     */
    private $configuration;

    /**
     * @param string $method
     *
     * @return HttpRequestInterface
     */
    public function setMethod(string $method): HttpRequestInterface
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $protocol
     *
     * @return HttpRequestInterface
     */
    public function setProtocol(string $protocol): HttpRequestInterface
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @param string $host
     *
     * @return HttpRequestInterface
     */
    public function setHost(string $host): HttpRequestInterface
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param string $port
     *
     * @return HttpRequestInterface
     */
    public function setPort(string $port): HttpRequestInterface
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return HttpRequestInterface
     */
    public function setPath(string $path): HttpRequestInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return HttpRequestInterface
     */
    public function setHeaders(array $headers): HttpRequestInterface
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return HttpRequestInterface
     */
    public function setToken(string $token): HttpRequestInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return HttpRequestInterface
     */
    public function setOptions(array $options): HttpRequestInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param array $body
     *
     * @return HttpRequestInterface
     */
    public function setBody(array $body): HttpRequestInterface
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param array $json
     *
     * @return HttpRequestInterface
     */
    public function setJson(array $json): HttpRequestInterface
    {
        $this->json = $json;

        return $this;
    }

    /**
     * @param HttpConfigurationInterface $configuration
     *
     * @return HttpRequestInterface
     */
    public function setConfiguration(HttpConfigurationInterface $configuration): HttpRequestInterface
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getJson(): array
    {
        return $this->json;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = [
            'headers' => $this->getHeaders(),
        ];

        if (count($this->getBody())) {
            $options = array_merge($options, ['body' => $this->getBody()]);
        }

        if (count($this->getJson())) {
            $options = array_merge($options, ['json' => $this->getJson()]);
        }

        return $options;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->port !== 80) {
            return "{$this->protocol}://{$this->getHost()}:{$this->getPort()}/{$this->getPath()}";
        }

        return "{$this->protocol}://{$this->getHost()}/{$this->getPath()}";
    }

    /**
     * @return HttpResponseInterface
     * @throws DataProviderException
     */
    public function execute(): HttpResponseInterface
    {
        $this->setHost($this->configuration->getHost());
        if (null !== $config = $this->configuration->getCredentials()) {
            foreach ($config as $prop => $value) {
                if (property_exists($this, $prop)) {
                    $this->{$prop} = $value;
                }
            }
        }
        return (new Client())->request($this);
    }
}

<?php

namespace App\Http\Client\Request;

use App\Http\Client\Response\HttpResponseInterface;

/**
 * Interface RequestInterface
 * @package App\Http\Client\Request
 */
interface HttpRequestInterface
{
    /**
     * @param string $method
     *
     * @return HttpRequestInterface
     */
    public function setMethod(string $method): self;

    /**
     * @param string $protocol
     *
     * @return HttpRequestInterface
     */
    public function setProtocol(string $protocol): self;

    /**
     * @param string $host
     *
     * @return HttpRequestInterface
     */
    public function setHost(string $host): self;

    /**
     * @param string $port
     *
     * @return HttpRequestInterface
     */
    public function setPort(string $port): self;

    /**
     * @param string $path
     *
     * @return HttpRequestInterface
     */
    public function setPath(string $path): self;

    /**
     * @param array $headers
     *
     * @return HttpRequestInterface
     */
    public function setHeaders(array $headers): self;

    /**
     * @param string $token
     *
     * @return HttpRequestInterface
     */
    public function setToken(string $token): self;

    /**
     * @param array $options
     *
     * @return HttpRequestInterface
     */
    public function setOptions(array $options): self;

    /**
     * @param array $body
     *
     * @return HttpRequestInterface
     */
    public function setBody(array $body): self;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return HttpRequestInterface
     */
    public function getProtocol(): string;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return int
     */
    public function getPort(): int;

    /**
     * @return string
     */
    public function getPath(): ?string;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @return string
     */
    public function getToken(): ?string;

    /**
     * @return array ['body', 'headers']
     */
    public function getOptions(): array;

    /**
     * @return array
     */
    public function getBody(): array;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return HttpResponseInterface
     */
    public function execute(): HttpResponseInterface;
}

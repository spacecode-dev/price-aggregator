<?php

namespace App\Http\Client\Response;

use Psr\Http\Message\ResponseInterface as ResponseInterface;

/**
 * Class AbstractResponse
 * @package App\Http\Client\Response
 */
class HttpResponse implements HttpResponseInterface
{
    /**
     * @var integer
     */
    private $status;

    /**
     * @var string[][]
     */
    private $headers;

    /**
     * @var string[][]
     */
    private $content;

    /**
     * HttpResponse constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->status = $response->getStatusCode();
        $this->headers = $response->getHeaders();
        $this->content = $response->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
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
    public function getContent(): string
    {
        return $this->content;
    }
}

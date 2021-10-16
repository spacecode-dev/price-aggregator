<?php

namespace App\Http\Client;

use App\Exceptions\DataProviderException;
use App\Http\Client\Request\HttpRequestInterface;
use App\Http\Client\Response\HttpResponse;
use App\Http\Client\Response\HttpResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class AbstractClient
 * @package App\Http\Client
 */
final class Client implements ClientInterface
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /**
     * AbstractClient constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param HttpRequestInterface $request
     *
     * @return HttpResponseInterface
     * @throws DataProviderException
     */
    public function request(HttpRequestInterface $request): HttpResponseInterface
    {
        $guzzleResponse = $this->client->request($request->getMethod(), $request->getUrl(), $request->getOptions());
        try {
            return new HttpResponse($guzzleResponse);
        } catch (RequestException $e) {
            if(
                $e->getCode() >= Response::HTTP_BAD_REQUEST &&
                $e->getCode() < Response::HTTP_FORBIDDEN &&
                $e->getCode() > Response::HTTP_NOT_FOUND &&
                $e->getCode() < Response::HTTP_UNPROCESSABLE_ENTITY &&
                $e->getCode() >= Response::HTTP_LOCKED
            ) {
                throw new DataProviderException($e->getMessage(), $e->getCode());
            }
            return new HttpResponse($e->getResponse());
        }
    }
}

<?php

namespace App\DataProvider\Shopify\Api\Collection;

use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class CheckCollection
 * @package App\DataProvider\Shopify\Api\Collection
 */
final class CheckCollection extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    protected $path = 'custom_collections/#{id}.json';

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace('#{id}', $this->id, $this->path);
    }

    /**
     * @return bool
     */
    public function handler(): bool
    {
        $this->changePath();
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return $response->getStatus() === 200 ? true : false;
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

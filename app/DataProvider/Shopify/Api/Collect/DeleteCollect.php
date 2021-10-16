<?php

namespace App\DataProvider\Shopify\Api\Collect;

use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class DeleteCollect
 * @package App\DataProvider\Shopify\Api\Collect
 */
final class DeleteCollect extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    protected $path = 'collects/#{id}.json';

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

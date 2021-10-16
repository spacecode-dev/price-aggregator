<?php

namespace App\DataProvider\Shopify\Api\Collection;

use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class DeleteCollection
 * @package App\DataProvider\Shopify\Api\Collection
 */
final class DeleteCollection extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var string
     */
    protected $path = 'custom_collections/#{id}.json';

    /**
     * @var integer
     */
    public $id;

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace('#{id}', $this->id, $this->path);
    }

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->changePath();
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();

            /** Add all collects */
            $this->removeCollects('collection_id', $this->id);

            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

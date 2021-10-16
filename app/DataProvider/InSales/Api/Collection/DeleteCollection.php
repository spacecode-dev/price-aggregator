<?php

namespace App\DataProvider\InSales\Api\Collection;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class DeleteCollection
 * @package App\DataProvider\InSales\Api\Collection
 */
final class DeleteCollection extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var string
     */
    protected $path = 'collections/#{id}.json';

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

            /** Remove all collects */
            $this->removeCollects('collection_id', $this->id);

            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

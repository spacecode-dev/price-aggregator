<?php

namespace App\DataProvider\InSales\Api\Collection;

use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\CollectionFactory;
use Throwable;

/**
 * Class ParentCollection
 * @package App\DataProvider\InSales\Api\Collection
 */
final class ParentCollection extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'collections.json';

    /**
     * @return int
     */
    public function handler(): int
    {
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return CollectionFactory::getParent($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

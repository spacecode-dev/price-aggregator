<?php

namespace App\DataProvider\InSales\Api\Category;

use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\CategoryFactory;
use Throwable;

/**
 * Class ParentCategory
 * @package App\DataProvider\InSales\Api\Category
 */
final class ParentCategory extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'categories.json';

    /**
     * @return int
     */
    public function handler(): int
    {
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return CategoryFactory::getParent($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

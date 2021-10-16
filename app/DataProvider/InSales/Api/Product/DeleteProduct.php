<?php

namespace App\DataProvider\InSales\Api\Product;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class DeleteProduct
 * @package App\DataProvider\InSales\Api\Product
 */
final class DeleteProduct extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var string
     */
    protected $path = 'products/#{id}.json';

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

            /** Remove all images */
            $this->removeImages($this->id);

            /** Remove all collects */
            $this->removeCollects('product_id', $this->id);

            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

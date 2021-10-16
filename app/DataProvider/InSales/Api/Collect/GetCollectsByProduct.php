<?php

namespace App\DataProvider\InSales\Api\Collect;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class GetCollectsByProduct
 * @package App\DataProvider\InSales\Api\Collect
 */
final class GetCollectsByProduct extends InSalesApi
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
    protected $path = 'collects.json?product_id=#{id}';

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
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

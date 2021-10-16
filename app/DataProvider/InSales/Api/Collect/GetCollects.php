<?php

namespace App\DataProvider\InSales\Api\Collect;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class GetCollects
 * @package App\DataProvider\InSales\Api\Collect
 */
final class GetCollects extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'collects.json';

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

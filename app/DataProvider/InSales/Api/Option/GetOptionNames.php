<?php

namespace App\DataProvider\InSales\Api\Option;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class GetOptionNames
 * @package App\DataProvider\InSales\Api\Option
 */
final class GetOptionNames extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'option_names.json';

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

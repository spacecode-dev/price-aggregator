<?php

namespace App\DataProvider\InSales\Api\Option;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class GetOptionValues
 * @package App\DataProvider\InSales\Api\Option
 */
final class GetOptionValues extends InSalesApi
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
    protected $path = 'option_names/#{id}/option_values.json';

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

<?php

namespace App\DataProvider\InSales\Api\Collection;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class CheckCollection
 * @package App\DataProvider\InSales\Api\Collection
 */
final class CheckCollection extends InSalesApi
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
    protected $path = 'collections/#{id}.json';

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

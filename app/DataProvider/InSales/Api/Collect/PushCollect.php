<?php

namespace App\DataProvider\InSales\Api\Collect;

use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\CollectFactory;
use Throwable;

/**
 * Class PushCollect
 * @package App\DataProvider\InSales\Api\Collect
 */
final class PushCollect extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'collects.json';

    /**
     * @return bool
     */
    public function handler(): bool
    {
        $this->body = CollectFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return $response->getStatus() === 201 ? true : false;
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

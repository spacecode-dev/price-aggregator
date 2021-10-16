<?php

namespace App\DataProvider\InSales\Api\Variant;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\VariantFactory;
use Throwable;

/**
 * Class PushVariant
 * @package App\DataProvider\InSales\Api\Variant
 */
final class PushVariant extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'products/#{id}/variants.json';

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
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        $this->changePath();
        $this->body = VariantFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return VariantFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}

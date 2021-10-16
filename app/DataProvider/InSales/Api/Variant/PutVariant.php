<?php

namespace App\DataProvider\InSales\Api\Variant;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\VariantFactory;
use Throwable;

/**
 * Class PutVariant
 * @package App\DataProvider\InSales\Api\Variant
 */
final class PutVariant extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'PUT';

    /**
     * @var string
     */
    protected $path = 'products/#{id}/variants/#{varId}.json';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $varId;

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace(['#{id}', '#{varId}'], [$this->id, $this->varId], $this->path);
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

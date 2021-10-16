<?php

namespace App\DataProvider\InSales\Api\Image;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class DeleteImage
 * @package App\DataProvider\InSales\Api\Image
 */
final class DeleteImage extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var string
     */
    protected $path = 'products/#{id}/images/#{imageId}.json';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $imageId;

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace(['#{id}', '#{imageId}'], [$this->id, $this->imageId], $this->path);
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

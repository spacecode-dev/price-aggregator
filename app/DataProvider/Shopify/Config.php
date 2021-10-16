<?php

namespace App\DataProvider\Shopify;

use App\Http\Client\Configuration\AbstractHttpConfiguration;
use App\Http\Client\Configuration\HttpConfigurationInterface;

/**
 * Class Config
 * @package App\DataProvider\Horoshop
 */
final class Config extends AbstractHttpConfiguration
{
    private static $instance = null;

    /**
     * Config constructor.
     *
     * Shopify api V. 2020-04 'https://shopify.dev/docs/admin-api/rest/reference'
     */
    private function __construct()
    {
        $this->setHost(env('SHOPIFY_URL') . '/admin/api/2020-04');
    }

    /**
     * @return static
     */
    public static function init(): HttpConfigurationInterface
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

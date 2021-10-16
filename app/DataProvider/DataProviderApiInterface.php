<?php

namespace App\DataProvider;

/**
 * Interface DataProviderApiInterface
 * @package App\DataProvider
 */
interface DataProviderApiInterface
{
    /**
     * @param DataProviderEntityInterface $providerEntity
     *
     * @return $this
     */
    public function setProviderEntity(DataProviderEntityInterface $providerEntity): self;

    /**
     * @return DataProviderEntityInterface
     */
    public function getProviderEntity(): DataProviderEntityInterface;

    /**
     * @return mixed
     */
    public function handler();
}

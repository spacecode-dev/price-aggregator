<?php

namespace App\DataProvider;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait ServiceResolver
{
    /**
     * Find DataProvider module by namespace
     *
     * @param string|null $serviceName
     * @param string|null $entity
     * @param string|null $action
     * @return string
     */
    public function findServiceByName(string $serviceName = null, string $entity = null, string $action = null): string
    {
        if (null === $serviceName || null === $entity || null === $action) {
            throw new BadRequestHttpException("Service name, entity or action can't be empty.");
        }

        $className = sprintf("App\DataProvider\%s\Api\%s\%s", ucfirst($serviceName), ucfirst($entity),
            ucfirst($action) . ucfirst($entity));

        if ( ! class_exists($className)) {
            throw new BadRequestHttpException("Service does't exist.");
        }

        return $className;
    }

    /**
     * Find DataProvider entity by namespace
     *
     * @param string|null $serviceName
     * @param string|null $entity
     *
     * @return string
     */
    public function findFactoryByChanel(string $serviceName = null, string $entity = null): string
    {
        if (null === $serviceName || null === $entity) {
            throw new BadRequestHttpException("Service name or entity can't be empty.");
        }

        $className = sprintf("App\DataProvider\%s\Factory\%s", ucfirst($serviceName), ucfirst($entity) . "Factory");

        if ( ! class_exists($className)) {
            throw new BadRequestHttpException("Factory does't exist.");
        }

        return $className;
    }
}

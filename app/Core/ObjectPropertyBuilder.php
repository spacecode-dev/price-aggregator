<?php

namespace App\Core;

use Illuminate\Support\Collection;
//use ReflectionClass;
use ReflectionException;

trait ObjectPropertyBuilder
{
    /** @var Collection */
    private $collection;

    /**
     * Set data from Request content into InternalEntityInterface object.
     *
     * @param InternalEntityInterface $entity
     * @param array $data
     *
     * @return InternalEntityInterface
     * @throws ReflectionException
     */
    protected function fillEntity(InternalEntityInterface $entity, array $data): InternalEntityInterface
    {
        foreach ($data as $property => $value) {
            if (property_exists($entity, $property)) {

                $className = $this->getNameSpaceFromProperty($entity, $property);

                if ($entity->{$property} instanceof Collection) {
                    if (null !== $className && class_exists($className)) {
                        $this->collection = new Collection();
                        $entity->{$property} = $this->collection;
                        $this->buildCollection(new $className, $value);
                    }
                } elseif (is_array($value)) {
                    if (null !== $className && class_exists($className)) {
                        $entity->{$property} = $this->buildNewInstance(new $className, $value);
                    } else {
                        $entity->{$property} = $value;
                    }
                } else {
                    $entity->{$property} = $value;
                }
            }
        }

        return $entity;
    }

    /**
     * @param InternalEntityInterface $entity
     * @param array                   $data
     *
     * @return InternalEntityInterface
     */
    private function buildNewInstance(InternalEntityInterface $entity, array $data): InternalEntityInterface
    {
        foreach ($data as $property => $value) {
            if (property_exists($entity, $property)) {
                $entity->{$property} = $value;
            }
        }

        return $entity;
    }

    /**
     * @param InternalEntityInterface $entity
     * @param array $data
     * @throws ReflectionException
     */
    private function buildCollection(InternalEntityInterface $entity, array $data)
    {
        foreach ($data as $property => $value) {
            if (is_array($value)) {
                if (is_int(array_key_last($value))) {
                    if (isset($entity->{$property}) && $entity->{$property} instanceof Collection) {
                        $className = $this->getNameSpaceFromProperty($entity, $property);
                        if (null !== $className && class_exists($className)) {
                            $collection = collect();
                            foreach ($value as $val) {
                                $collection->push($this->buildNewInstance(new $className, $val));
                            }
                            $entity->{$property} = $collection;
                        } else {
                            $entity->{$property} = $value;
                        }
                    } else {
                        $entity->{$property} = $value;
                    }
                } else {
                    $entity = new $entity;
                    $this->collection->push($entity);
                    $this->buildCollection($entity, $value);
                }
            } else {
                $entity->{$property} = $value;
            }
        }
    }

    /**
     * @param \App\Core\InternalEntityInterface $entity
     * @param string                            $field
     *
     * @return string|null
     * @throws \ReflectionException
     */
    protected function getNameSpaceFromProperty(InternalEntityInterface $entity, string $field): ?string
    {
        if (property_exists($entity, $field)) {
            $reflection = new \ReflectionClass($entity);
            $doc = $reflection->getProperty($field)->getDocComment();
            $pattern = "(\\\[A-z]+\b(?!_))";

            if (preg_match($pattern, $doc, $matches) && count($matches)) {
                return $matches[0];
            }
        }

        return null;
    }
}

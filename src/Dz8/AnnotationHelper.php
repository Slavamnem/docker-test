<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 03.04.20
 * Time: 18:51
 */

namespace App\Dz8;

class AnnotationHelper
{
    /**
     * @var
     */
    private $object;

    /**
     * @param $model
     * @return array
     * @throws \ReflectionException
     */
    public function getModelColumns($model): array
    {
        $this->object = $model;
        $modelColumns = [];

        foreach ($this->getModelProperties($model) as $modelProperty) {
            $modelProperty->setAccessible(true);

            if ($this->isColumn($modelProperty)) {
                if ($this->isAutoIncrementColumn($modelProperty)) {
                    continue;
                }

                $propertyName = $this->getPropertyName($modelProperty);

                $modelColumns[$propertyName] = $modelProperty->getValue($this->object);

                if ($this->isCreatedAtColumn($modelProperty)) {
                    $modelColumns[$propertyName] = $modelColumns[$propertyName] ?: (new \DateTime())->format('Y-m-d H:i:s');
                }
            }
        }

        return $modelColumns;
    }

    /**
     * @param $model
     * @return array
     * @throws \ReflectionException
     */
    private function getModelProperties($model): array
    {
        return (new \ReflectionClass($model))->getProperties();
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return bool
     */
    private function isColumn(\ReflectionProperty $reflectionProperty): bool
    {
        return strrpos($reflectionProperty->getDocComment(), '@Column') !== false;
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return bool
     */
    private function isAutoIncrementColumn(\ReflectionProperty $reflectionProperty): bool
    {
        return $this->getPropertyType($reflectionProperty) == 'autoincrement';
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return string
     */
    private function getPropertyName(\ReflectionProperty $reflectionProperty)
    {
        preg_match('|name="(?<fieldName>[a-z_]*)"|', $reflectionProperty->getDocComment(), $matches);

        return $matches['fieldName'] ?: $reflectionProperty->getName();
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return string
     */
    private function getPropertyType(\ReflectionProperty $reflectionProperty)
    {
        preg_match('|type="(?<fieldType>[a-z]*)"|', $reflectionProperty->getDocComment(), $matches);

        return $matches['fieldType'] ?: gettype($reflectionProperty->getValue($this->object));
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return bool
     */
    private function isCreatedAtColumn(\ReflectionProperty $reflectionProperty): bool
    {
        return $this->getPropertyType($reflectionProperty) == "date";
    }
}
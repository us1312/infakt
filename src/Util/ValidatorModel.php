<?php

namespace SCA\InFakt\Util;

class ValidatorModel
{
    public static function validateRequiredFields(object $object): bool|array
    {
        $reflection = new \ReflectionClass($object);
        $properties = $reflection->getProperties();

        $missingFields = [];

        foreach ($properties as $property) {
            $type = $property->getType();

            if ($type && !$type->allowsNull()) {
                $property->setAccessible(true);
                $value = $property->getValue($object);

                if (empty($value)) {
                    $missingFields[] = $property->getName();
                }
            }
        }

        return empty($missingFields) ? true : $missingFields;
    }
}
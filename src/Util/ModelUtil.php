<?php

namespace SCA\InFakt\Util;

class ModelUtil
{
    private static function camelToSnake(string $input): string {
        return strtolower(preg_replace('/[A-Z]/', '_$0', $input));
    }


    public static function getAll(object $object): array {
        $reflection = new \ReflectionClass($object);
        $properties = $reflection->getProperties();

        $result = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $name = $property->getName();
            $snakeName = self::camelToSnake($name);

            if ($property->isInitialized($object)) {
                $value = $property->getValue($object);
                if ($value !== null && $value !== '') {
                    $result[$snakeName] = $value;
                }
            }
        }

        return $result;
    }

    public static function splitFullName(string $fullName): array {
        $fullName = trim($fullName);

        $parts = explode(' ', $fullName);

        if (count($parts) === 1) {
            return [
                'firstName' => $parts[0],
                'lastName' => ''
            ];
        }

        $firstName = array_shift($parts);
        $lastName = implode(' ', $parts);

        return [
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
    }
}
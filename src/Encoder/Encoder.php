<?php

namespace App\Encoder;

class Encoder
{
    public static function encode(string $json, $class): ?array
    {
        $json = json_decode($json, true);
        $class = new \ReflectionClass($class);
        $properties = $class->getProperties();
        $entity = $class->newInstance();
        foreach ($properties as $property) {
            $entity->{$property->getName()} = $property->getValue($entity);
        }
        return $entity;
    }


}
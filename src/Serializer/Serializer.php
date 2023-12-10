<?php

namespace App\Serializer;

class Serializer
{

    public function __construct()
    {}

    public static function serialize($entity): ?array
    {
        // TODO: Implement serialize() on associations
        $class = new \ReflectionClass($entity);
        $properties = $class->getProperties();
        $json = [];
        foreach ($properties as $property) {
            $json[$property->getName()] = $property->getValue($entity);
        }
        return $json;
    }

    public static function serializeAll($entities): ?array
    {
        $json = [];
        foreach ($entities as $entity) {
            $class = new \ReflectionClass($entity);
            $properties = $class->getProperties();
            $serializedEntity = [];
            foreach ($properties as $property) {
                $serializedEntity[$property->getName()] = $property->getValue($entity);
            }
            $json[] = $serializedEntity;
        }
        return $json;
    }



}
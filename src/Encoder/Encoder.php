<?php

namespace App\Encoder;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class Encoder
{

    public function __construct(){}
    /**
     * @throws \ReflectionException
     */
    public static function encode(string $json, $class): ?object
    {
        $json = json_decode($json, true);
        $class = new \ReflectionClass($class);
        $properties = $class->getProperties();
        $entity = $class->newInstance();
        foreach ($properties as $property) {
            if (array_key_exists($property->getName(), $json)) {
                $property->setValue($entity, $json[$property->getName()]);
            }
            if (in_array('Symfony\Component\Security\Core\User\UserInterface', class_implements($entity))) {
                if ($property->getName() === 'password') {
                    $passwordHasherFactory = new PasswordHasherFactory([
                        // auto hasher with default options for the User class (and children)
                        User::class => ['algorithm' => 'auto'],

                        // auto hasher with custom options for all PasswordAuthenticatedUserInterface instances
                        PasswordAuthenticatedUserInterface::class => [
                            'algorithm' => 'auto',
                            'cost' => 15,
                        ],
                    ]);
                    $passwordHasher = new UserPasswordHasher($passwordHasherFactory);
                    $property->setValue($entity, $passwordHasher->hashPassword($entity, $property->getValue($entity)));
                }
                if ($property->getName() === 'roles') {
                    $property->setValue($entity, ['ROLE_USER']);
                }
            }
        }
        return $entity;
    }



}
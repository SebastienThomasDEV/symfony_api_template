<?php

namespace App\Controller;

use App\Encoder\Encoder;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Serializer\Serializer;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Annotations\Test;
use Symfony\Flex\Response;

class UserController extends AbstractController
{
    public function __construct(){}
    #[Route('/api/users/read', name: 'app_users', methods: ['GET'], format: 'json')]
    public function readAll(UserRepository $userRepository): JsonResponse
    {
        try {
            return $this->json(Serializer::serializeAll($userRepository->findAll()));
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/users/read/{id}', name: 'app_user', methods: ['GET'], format: 'json')]
    public function readOne(Request $request, UserRepository $userRepository): JsonResponse
    {
        try {
            return $this->json(Serializer::serialize($userRepository->find($request->get('id'))));
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/users/create', name: 'app_user_create', methods: ['POST'], format: 'json')]
    public function create(Request $request, UserRepository $userRepository): JsonResponse
    {
        try {
            $user = Encoder::encode($request->getContent(), User::class);
            $userRepository->save($user);
            return $this->json(Serializer::serialize($user));
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/users/update/{id}', name: 'app_user_update', methods: ['PUT'], format: 'json')]
    public function update(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users/delete/{id}', name: 'app_user_delete', methods: ['DELETE'], format: 'json')]
    public function delete(): JsonResponse
    {

    }

}

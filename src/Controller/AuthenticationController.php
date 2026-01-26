<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class AuthenticationController extends AbstractController
{
    /**
     * Pour créer un nouvel utilisateur
     */
    #[Route('/api/users/create', name: 'api_create_user', methods: ['POST'])]
    public function createUser(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles($data['roles'] ?? ['ROLE_USER']);
        $user->setPassword(
            $passwordHasher->hashPassword($user, $data['password'])
        );

        $em->persist($user);
        $em->flush();

        return $this->json(['status' => 'User created']);
    }

    /**
     * Pour récupérer le profil de l'utilisateur connecté
     */
    #[Route('/api/profile', name: 'api_profile', methods: ['GET'])]
    public function profile(): JsonResponse
    {
        $user = $this->getUser(); // Symfony récupère le User du token
        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }
}

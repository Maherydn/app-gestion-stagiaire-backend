<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    #[Route('/api/user_info', name: 'user.info', methods: ['GET'])]
    public function getUserInfo(): Response
    {
        // Assure-toi que le token est présent et valide
        $token = $this->tokenStorage->getToken();
        if (!$token || !$token->getUser() instanceof UserInterface) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        // Obtient les informations utilisateur
        $user = $token->getUser();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }
}

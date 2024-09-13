<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'app.create')]
    public function index(EntityManagerInterface $em, UserPasswordHasherInterface
                                                 $userPasswordHasher): Response
    {
        $user = new User();

        $user->setUsername('daniel');
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                '12456'
            )
        );
        $em->persist($user);
        $em->flush();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}




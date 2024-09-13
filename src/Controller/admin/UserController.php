<?php

namespace App\Controller\admin;



use App\DTO\UserCreateDTO;
use App\DTO\UserUpdateDTO;
use App\Entity\User;
use App\Repository\DepartementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseCookieValueSame;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/admin/user', name: 'admin.user')]
class UserController  extends AbstractController
{

    #[Route( '/create', name: '.create', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload] UserCreateDTO $userCreateDTO,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        DepartementRepository $departementRepository,
    ): Response {
        $user = new User();

        $userProps = [
            'username' => 'setUsername',
            'email' => 'setEmail',
            'roles' => 'setRoles',
            'matricule' => 'setMatricule',
            'departement' => 'setDepartement',
        ];

        foreach ($userProps as $prop => $setter) {
            $value = $userCreateDTO->$prop;

            if ($value !== null && $value !== '') {
                if ($prop === 'roles' && !is_array($value)) {
                    return $this->json(['error' => 'Le champ roles doit être un tableau.'], Response::HTTP_BAD_REQUEST);
                }
                if ($prop === 'departement') {
                    $departement = $departementRepository->find($value);
                    $user->$setter($departement);
                }else {
                    $user->$setter($value);
                }

            }
        }

        // Pour mdp
        if (isset($userCreateDTO->password) && !empty($userCreateDTO->password)) {
            $hashedPassword = $passwordHasher->hashPassword($user, $userCreateDTO->password);
            $user->setPassword($hashedPassword);
        }

        $em->persist($user);
        $em->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route( '', name: '.read', methods: ['GET'])]
    public function read(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
         );
    }

    #[Route('/{id}', name: '.update', requirements: ['id' => Requirement::DIGITS], methods: ['PATCH'])]
    public function updateUser(
        User $user,
        #[MapRequestPayload] UserUpdateDTO $userUpdateDTO,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        DepartementRepository $departementRepository
    ): Response {
        // Mapping des champs à mettre à jour
        $userProps = [
            'username' => 'setUsername',
            'email' => 'setEmail',
            'roles' => 'setRoles',
            'matricule' => 'setMatricule',
            'departement' => 'setDepartement',
        ];

        foreach ($userProps as $prop => $setter) {
            $value = $userUpdateDTO->$prop;

            if ($value !== null && $value !== '') {
                if ($prop === 'roles' && !is_array($value)) {
                    return $this->json(['error' => 'Le champ roles doit être un tableau.'], Response::HTTP_BAD_REQUEST);
                }
                if ($prop === 'departement') {
                    $departement = $departementRepository->find($value);
                    $user->$setter($departement);
                }else {
                    $user->$setter($value);
                }
            }
        }

        // Pour mdp
        if (isset($userUpdateDTO->password) && !empty($userUpdateDTO->password)) {
            $hashedPassword = $passwordHasher->hashPassword($user, $userUpdateDTO->password);
            $user->setPassword($hashedPassword);
        }

        $em->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('/{id}', name: '.show', requirements: ['id' => Requirement::DIGITS], methods: ['GET'])]
    public function showUser(User $user): Response
    {
        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('/{id}', name: '.delete', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();

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
<?php

namespace App\Controller\admin;

use App\DTO\DepartementCreateDTO;
use App\Entity\Departement;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/departement', name: 'admin.departement' )]
class DepartementController extends AbstractController
{
    #[Route('/create', name: '.create', methods: ['POST'])]
    public function createDepartement(
        #[MapRequestPayload] DepartementCreateDTO $departementCreateDTO,
        EntityManagerInterface $em,
    ): Response
    {
        $departement =  new Departement();

        $departementProps = [
            'name' => 'setName',
        ];

        foreach ($departementProps as $prop => $setter) {
            $value = $departementCreateDTO->$prop;

            if ($value !== null && $value !== '') {
                $departement->$setter($value);
            }
        }

        $em->persist($departement);
        $em->flush();

        return $this->json(
            $departement,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('', name: '.reads', methods: ['GET'])]
    public function readDepartements(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAll();

        return $this->json(
            $departements,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('/{id}', name: '.read', methods: ['GET'])]
    public function readDepartement(Departement $departement): Response
    {

        return $this->json(
            $departement,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('/{id}', name: '.update', methods: ['POST'])]
    public function updateDepartement(
        Departement $departement,
        #[MapRequestPayload] DepartementCreateDTO $departementCreateDTO,
        EntityManagerInterface $em,
    ): Response
    {
        $departementProps = [
            'name' => 'setName',
        ];

        foreach ($departementProps as $prop => $setter) {
            $value = $departementCreateDTO->$prop;

            if ($value !== null && $value !== '') {
                $departement->$setter($value);
            }
        }

        $em->flush();

        return $this->json(
            $departement,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }

    #[Route('/{id}', name: '.delete', methods: ['DELETE'])]
    public function deleteDepartement(
        Departement $departement,
        EntityManagerInterface $em,
    ): Response
    {

        $em->remove($departement);
        $em->flush();

        return $this->json(
            $departement,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['admin.show']
            ]
        );
    }
}

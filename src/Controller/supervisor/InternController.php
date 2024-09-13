<?php

namespace App\Controller\supervisor;

use App\Entity\Intern;
use App\Entity\User;
use App\Repository\DepartementRepository;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/api/supervisor/intern', name: 'supervisor.intern')]
class InternController extends AbstractController
{

    #[Route('/validate/{id}', name: '.validate', requirements: ['id' => Requirement::DIGITS], methods: ['POST', 'GET'])]
    public function delete(Intern $intern, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $intern->setStatus('validate');
        $intern->setUser($user);
        $em->flush();
        return $this->json($intern, 200, [], [
            'groups' => ['supervisor.show']
        ]);
    }

    #[Route( name: '.read', methods: ['GET'])]
    public function read(InternRepository $internRepository, DepartementRepository $departementRepository): Response
    {
        $user = $this->getUser();
        dd($user);
        $idDepartement = $user->getDepartement()->getId();

        $departements = $departementRepository->find($idDepartement);
        $interns = $internRepository->findByDepartement($departements);

        return $this->json($interns, 200, [], [
            'groups' => ['supervisor.show']
        ]);
    }
}

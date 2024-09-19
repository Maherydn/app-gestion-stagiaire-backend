<?php

namespace App\Controller\admin;

use App\Entity\Intern;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/intern', name: 'admin.intern')]
class InternController extends AbstractController
{
    #[Route(name: '.read', methods: ['GET'])]
    public function read(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findAll();

        return $this->json($interns, 200, [], [
            'groups' => ['recruiter.show']
        ]);
    }


    #[Route('/{id}', name: '.delete', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'])]
    public function delete(Intern $intern, EntityManagerInterface $em): Response
    {
        $em->remove($intern);
        $em->flush();
        return $this->json($intern, 200, [], [
            'groups' => ['recruiter.show']
        ]);
    }
}

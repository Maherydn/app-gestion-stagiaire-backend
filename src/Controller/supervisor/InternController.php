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

#[Route('api/supervisor/intern', name: 'supervisor.intern')]
class InternController extends AbstractController
{

    #[Route('/validate/{id}', name: '.validate', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function validate(Intern $intern, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $intern->setStatus('validate');
        $intern->setUser($user);
        $em->flush();
        return $this->json($intern, 200, [], [
            'groups' => ['supervisor.show']
        ]);
    }

    #[Route('/invalidate/{id}', name: '.invalidate', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function invalidate(Intern $intern, EntityManagerInterface $em): Response
    {

        $intern->setStatus('invalidate');
        $em->flush();
        return $this->json($intern, 200, [], [
            'groups' => ['supervisor.show']
        ]);
    }

    #[Route( name: '.read', methods: ['GET'])]
    public function read(InternRepository $internRepository, DepartementRepository $departementRepository): Response
    {
        $user = $this->getUser();
        $idDepartement = $user->getDepartement()->getId();

        $departements = $departementRepository->find($idDepartement);
        $interns = $internRepository->findByDepartement($departements);

        return $this->json($interns, 200, [], [
            'groups' => ['supervisor.show']
        ]);
    }
    #[Route('/internshipCv/{id}', name: 'readCv', methods: ['GET'])]
    public function getCvUrl(Intern $intern): Response
    {
        // Utilisation de VichUploader pour obtenir l'URL du fichier
        $documentUrl = $this->getParameter('kernel.project_dir') . '/public/files/cv/' . $intern->getIntershipCv();

        // Vérifier si le fichier existe avant de renvoyer une réponse
        if (!file_exists($documentUrl)) {
            return $this->json(['error' => 'CV non trouvé'], 404);
        }

        // Retourner l'URL relative pour l'utiliser dans React
        return $this->json([
            'cvUrl' => '/files/cv/' . $intern->getIntershipCv()
        ], 200);
    }



    #[Route( '/intershipDemand/{id}', name: '.readDemand', methods: ['GET'])]
    public function getDemandUrl(Intern $intern): Response
    {
        $documentUrl = '/uploads/documents/' . $intern->getIntershipDemand();

        return $this->json($documentUrl, 200, [], []);
    }
}

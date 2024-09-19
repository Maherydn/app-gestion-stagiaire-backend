<?php

namespace App\Controller\recruiter;

use App\Entity\Departement;
use App\Entity\Intern;
use App\Repository\DepartementRepository;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/api/recruiter/intern', name: 'recruiter.intern')]
class InternController extends AbstractController
{
    #[Route('/create', name: '.create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $intern = new Intern();
        $formData = $request->request->all();

        $intern->setCreatedAt(new \DateTimeImmutable());
        $intern->setUpdatedAt(new \DateTimeImmutable());

        foreach ($formData as $key => $value) {
            if (property_exists($intern, $key)) {
                $setter = 'set' . ucfirst($key);
                $intern->$setter($value);
            }
        }

        $fileMappings = [
            'intershipCv' => 'IntershipCvFile',
            'intershipDemand' => 'IntershipDemandFile',
        ];

        foreach ($fileMappings as $fileKey => $methodSuffix) {
            if ($file = $request->files->get($fileKey)) {
                if ($file->getClientMimeType() !== 'application/pdf') {
                    return $this->json(['error' => 'Invalid file type, only PDFs are allowed'], Response::HTTP_BAD_REQUEST);
                }
                $method = 'set' . $methodSuffix;
                if (method_exists($intern, $method)) {
                    $intern->$method($file);
                }
            }
        };

//        if ($cvFile = $request->files->get('cvFile')) {
//            $intern->setCvFile($cvFile);
//        };
//
//        if ($intershipDemand = $request->files->get('intershipDemand')) {
//            $intern->setIntershipDemandFile($intershipDemand);
//        };
        $em->persist($intern);
        $em->flush();

        return $this->json($intern, Response::HTTP_CREATED, [], [
            'groups' => ['recruiter.show'],
        ]);
    }

    #[Route( name: '.read', methods: ['GET'])]
    public function read(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findAll();

        return $this->json($interns, 200, [], [
            'groups' => ['recruiter.show']
        ]);
    }

    #[Route('/{id}', name: '.update', requirements: ['id' => Requirement::DIGITS], methods: ['POST', 'GET'])]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        Intern $intern,
        DepartementRepository $departementRepository,
    ): Response
    {

        $formData = $request->request->all();
        foreach ($formData as $key => $value) {
            if (property_exists($intern, $key)) {
                $setter = 'set' . ucfirst($key);

                if (in_array($key, ['intershipStartAt', 'intershipFinishAt'])) { // Liste des propriétés à traiter comme des dates
                    $dateValue = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
                    if ($dateValue) {
                        $intern->$setter($dateValue);
                    }
                } else if ($key === 'departement') {
                    $departement = $departementRepository->find($value);
                    if ($departement) {
                        $intern->setDepartement($departement);
                    }
                } else {
                    $intern->$setter($value);
                }
            }
        }

        $fileMappings = [
            'intershipCv' => 'IntershipCvFile',
            'intershipDemand' => 'IntershipDemandFile',
            'intershipAuthorization' => 'IntershipAuthorizationFile',
        ];

        foreach ($fileMappings as $fileKey => $methodSuffix) {
            if ($file = $request->files->get($fileKey)) {
                $method = 'set' . $methodSuffix;
                if (method_exists($intern, $method)) {
                    $intern->$method($file);
                }
            }
        };

        $intern->setUpdatedAt(new \DateTimeImmutable());

        $em->flush();

        return $this->json($intern, 200, [], [
            'groups' => ['recruiter.show'],
        ]);
    }
}

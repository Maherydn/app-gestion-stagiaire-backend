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

#[Route('/recruiter/intern', name: 'recruiter.intern')]
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
            'cvFile' => 'CvFile',
            'intershipDemandFile' => 'IntershipDemandFile',
        ];

        foreach ($fileMappings as $fileKey => $methodSuffix) {
            if ($file = $request->files->get($fileKey)) {
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
    public function read(InternRepository $internRepository, DepartementRepository $departementRepository): Response
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
                if ($key === 'departement') {
                    $departement = $departementRepository->find($value);
                    $intern->setDepartement($departement);
                }else{
                    $setter = 'set' . ucfirst($key);
                    $intern->$setter($value);
                }
            }
        }
        $fileMappings = [
            'intershipCvFile' => 'IntershipCvFile',
            'intershipDemandFile' => 'IntershipDemandFile',
//            autorisation , attestation,
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

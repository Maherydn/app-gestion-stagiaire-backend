<?php

namespace App\Entity;

use App\Repository\InternRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: InternRepository::class)]
#[Vich\Uploadable()]
class Intern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $university = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $studyLevel = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $status = 'invalidate';

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?string $intershipCv = null;

    #[Vich\UploadableField(mapping: 'cv', fileNameProperty: 'intershipCv')]
    private ?File $intershipCvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['recruiter.show'])]
    private ?string $intershipDemand = null;

    #[Vich\UploadableField(mapping: 'intershipDemand', fileNameProperty: 'intershipDemand')]
    private ?File $intershipDemandFile = null;

    #[Groups(['recruiter.show'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intershipAuthorization = null;

    #[Vich\UploadableField(mapping: 'intershipAuthorization', fileNameProperty: 'intershipAuthorization')]
    private ?File $intershipAuthorizationFile = null;

    #[Groups(['recruiter.show'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intershipConvention = null;

    #[Groups(['recruiter.show'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intershipAttestation = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recruiter.show'])]
    private ?int $intershipNumber = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?\DateTimeImmutable $intershipStartAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?\DateTimeImmutable $intershipFinishAt = null;

    #[Groups(['recruiter.show'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intershipDuration = null;

    #[ORM\ManyToOne(inversedBy: 'interns')]
    #[Groups(['admin.show', 'supervisor.show'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'interns')]
    #[Groups(['recruiter.show', 'supervisor.show'])]
    private ?Departement $departement = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $statusUpdatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function setUniversity(string $university): static
    {
        $this->university = $university;

        return $this;
    }

    public function getStudyLevel(): ?string
    {
        return $this->studyLevel;
    }

    public function setStudyLevel(string $studyLevel): static
    {
        $this->studyLevel = $studyLevel;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIntershipCv(): ?string
    {
        return $this->intershipCv;
    }

    public function setIntershipCv(?string $intershipCv): void
    {
        $this->intershipCv = $intershipCv;
    }

    public function getIntershipDemand(): ?string
    {
        return $this->intershipDemand;
    }

    public function setIntershipDemand(?string $intershipDemand): static
    {
        $this->intershipDemand = $intershipDemand;

        return $this;
    }

    public function getIntershipAuthorization(): ?string
    {
        return $this->intershipAuthorization;
    }

    public function setIntershipAuthorization(?string $intershipAuthorization): static
    {
        $this->intershipAuthorization = $intershipAuthorization;

        return $this;
    }

    public function getIntershipConvention(): ?string
    {
        return $this->intershipConvention;
    }

    public function setIntershipConvention(?string $intershipConvention): static
    {
        $this->intershipConvention = $intershipConvention;

        return $this;
    }

    public function getIntershipAttestation(): ?string
    {
        return $this->intershipAttestation;
    }

    public function setIntershipAttestation(?string $intershipAttestation): static
    {
        $this->intershipAttestation = $intershipAttestation;

        return $this;
    }

    public function getIntershipNumber(): ?int
    {
        return $this->intershipNumber;
    }

    public function setIntershipNumber(?int $intershipNumber): static
    {
        $this->intershipNumber = $intershipNumber;

        return $this;
    }

    public function getIntershipStartAt(): ?\DateTimeImmutable
    {
        return $this->intershipStartAt;
    }

    public function setIntershipStartAt(?\DateTimeImmutable $intershipStartAt): static
    {
        $this->intershipStartAt = $intershipStartAt;

        return $this;
    }

    public function getIntershipFinishAt(): ?\DateTimeImmutable
    {
        return $this->intershipFinishAt;
    }

    public function setIntershipFinishAt(?\DateTimeImmutable $intershipFinishAt): static
    {
        $this->intershipFinishAt = $intershipFinishAt;

        return $this;
    }

    public function getIntershipDuration(): ?string
    {
        return $this->intershipDuration;
    }

    public function setIntershipDuration(?string $intershipDuration): static
    {
        $this->intershipDuration = $intershipDuration;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getIntershipCvFile(): ?File
    {
        return $this->intershipCvFile;
    }

    public function setIntershipCvFile(?File $intershipCvFile): static
    {
        $this->intershipCvFile = $intershipCvFile;
        return $this;
    }

    public function getIntershipDemandFile(): ?File
    {
        return $this->intershipDemandFile;
    }

    public function setIntershipDemandFile(?File $intershipDemandFile): static
    {
        $this->intershipDemandFile = $intershipDemandFile;
        return $this;
    }

    public function getIntershipAuthorizationFile(): ?File
    {
        return $this->intershipAuthorizationFile;
    }

    public function setIntershipAuthorizationFile(?File $intershipAuthorizationFile): void
    {
        $this->intershipAuthorizationFile = $intershipAuthorizationFile;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatusUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->statusUpdatedAt;
    }

    public function setStatusUpdatedAt(?\DateTimeImmutable $statusUpdatedAt): static
    {
        $this->statusUpdatedAt = $statusUpdatedAt;

        return $this;
    }
}

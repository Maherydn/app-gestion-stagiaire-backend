<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TestRepository::class)]
#[Vich\Uploadable()]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $file = null;
    #[Vich\UploadableField(mapping: 'file', fileNameProperty: 'file')]
    private ?File $fileUpload = null;

    public function getFileUpload(): ?File
    {
        return $this->fileUpload;
    }

    public function setFileUpload(?File $fileUpload): static
    {
        $this->fileUpload = $fileUpload;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }
}

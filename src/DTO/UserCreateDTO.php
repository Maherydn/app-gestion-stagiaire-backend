<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateDTO
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public readonly ?string $username,

        #[Assert\NotBlank]
        public readonly ?array $roles,

        #[Assert\NotBlank]
        public readonly ?string $password,

        #[Assert\NotBlank]
        public readonly ?string $email,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public readonly ?int $matricule,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public readonly ?int $departement
    )
    {
    }
}


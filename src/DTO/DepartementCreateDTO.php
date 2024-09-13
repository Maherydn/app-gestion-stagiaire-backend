<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DepartementCreateDTO
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public readonly ?string $name,

    )
    {
    }
}
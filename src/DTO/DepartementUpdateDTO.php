<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DepartementUpdateDTO
{
    public function __construct(
        #[Assert\Type('string')]
        public readonly ?string $name,

    )
    {
    }
}
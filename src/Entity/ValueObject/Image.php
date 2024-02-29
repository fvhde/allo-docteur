<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Image
{
    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $path;

    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
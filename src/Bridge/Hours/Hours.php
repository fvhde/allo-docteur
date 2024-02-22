<?php

declare(strict_types=1);

namespace App\Bridge\Hours;

use App\Entity\Trait\Timestamp\Timestampable;
use Spatie\OpeningHours\OpeningHours;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Hours extends OpeningHours
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected null|string|Uuid $id;

    #[ORM\Column(type: 'simple_array')]
    protected $data;

    #[ORM\Column(type: 'simple_array')]
    protected array $openingHours = [];

    #[ORM\Column(type: 'simple_array')]
    protected array $exceptions = [];

    #[ORM\Column(type: 'simple_array')]
    protected array $filters = [];

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeZone $timezone = null;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeZone $outputTimezone = null;

    #[ORM\Column(type: 'boolean')]
    protected bool $overflow = false;

    #[ORM\Column(type: 'boolean')]
    protected ?int $dayLimit = null;

    #[ORM\Column]
    protected string $dateTimeClass = \DateTime::class;
}
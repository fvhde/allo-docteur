<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use App\Entity\Professional;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class OpeningHour
{
    public const DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private $id;

    #[ORM\Column]
    private string $day;

    #[ORM\Column(type: 'boolean')]
    private bool $opened = false;

    #[ORM\Column(nullable: true)]
    private ?string $fromTime;

    #[ORM\Column(nullable: true)]
    private ?string $toTime;

    #[ORM\ManyToOne(targetEntity: Professional::class, inversedBy: 'hours')]
    #[ORM\JoinColumn(name: 'professional_id', referencedColumnName: 'id')]
    private Professional $professional;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function setDay(string $day): OpeningHour
    {
        $this->day = $day;
        return $this;
    }

    public function isOpened(): bool
    {
        return $this->opened;
    }

    public function setOpened(bool $opened): OpeningHour
    {
        $this->opened = $opened;
        return $this;
    }

    public function getFromTime(): ?\DateTime
    {
        if (!$this->fromTime) {
            return $this->fromTime;
        }

        return \DateTime::createFromFormat('H:i', $this->fromTime);
    }

    public function setFromTime(null|\DateTimeInterface|string $from): OpeningHour
    {
        if ($from instanceof \DateTimeInterface) {
            $this->fromTime = $from->format('H:i');
        } else {
            $this->fromTime = $from;
        }

        return $this;
    }

    public function getToTime(): ?\DateTime
    {
        if (!$this->toTime) {
            return $this->toTime;
        }

        return \DateTime::createFromFormat('H:i', $this->toTime);
    }

    public function setToTime(null|\DateTimeInterface|string $to): OpeningHour
    {
        if ($to instanceof \DateTimeInterface) {
            $this->toTime = $to->format('H:i');
        } else {
            $this->toTime = $to;
        }

        return $this;
    }

    public function getProfessional(): Professional
    {
        return $this->professional;
    }

    public function setProfessional(Professional $professional): OpeningHour
    {
        $this->professional = $professional;

        return $this;
    }
}
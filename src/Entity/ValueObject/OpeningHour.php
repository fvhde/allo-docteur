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
    private ?string $from;

    #[ORM\Column(nullable: true)]
    private ?string $to;

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

    public function getFrom(): ?\DateTime
    {
        if (!$this->from) {
            return $this->from;
        }

        return \DateTime::createFromFormat('H:i', $this->from);
    }

    public function setFrom(null|\DateTimeInterface|string $from): OpeningHour
    {
        if ($from instanceof \DateTimeInterface) {
            $this->from = $from->format('H:i');
        } else {
            $this->from = $from;
        }

        return $this;
    }

    public function getTo(): ?\DateTime
    {
        if (!$this->to) {
            return $this->to;
        }

        return \DateTime::createFromFormat('H:i', $this->to);
    }

    public function setTo(null|\DateTimeInterface|string $to): OpeningHour
    {
        if ($to instanceof \DateTimeInterface) {
            $this->to = $to->format('H:i');
        } else {
            $this->to = $to;
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
<?php

declare(strict_types=1);

namespace App\Entity\Professional;


use App\Entity\Professional;
use App\Entity\Speciality;
use App\Repository\ProfessionalSpecialityRepository;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionalSpecialityRepository::class)]
class ProfessionalSpeciality
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['ap_create', 'user_list', 'user_detail'])]
    protected null|string|Uuid $id;

    #[ORM\ManyToOne(targetEntity: Professional::class, inversedBy: 'specialities')]
    protected ?Professional $professional = null;

    #[ORM\ManyToOne(targetEntity: Speciality::class, inversedBy: 'professionals')]
    protected ?Speciality $speciality = null;

    #[ORM\Column]
    protected ?int $duration = null;

    protected ?float $cost = null;

    public function __toString(): string
    {
        return $this->speciality?->getName() ?? '';
    }

    public function getId(): string|Uuid|null
    {
        return $this->id;
    }

    public function setId(string|Uuid|null $id): ProfessionalSpeciality
    {
        $this->id = $id;

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(?Professional $professional): ProfessionalSpeciality
    {
        $this->professional = $professional;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): ProfessionalSpeciality
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): ProfessionalSpeciality
    {
        $this->duration = $duration;

        return $this;
    }
}
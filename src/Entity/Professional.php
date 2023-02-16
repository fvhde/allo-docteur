<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Professional extends User
{
    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'professionals')]
    #[ORM\JoinColumn(name: 'place_id', referencedColumnName: 'id')]
    #[Groups(['pro_create', 'pro_detail'])]
    private Place $place;

    /**
     * @var string[]
     */
    #[ORM\Column(type: 'json')]
    #[Groups(['pro_detail'])]
    private array $hours = [];

    #[ORM\ManyToMany(targetEntity: Speciality::class, inversedBy: 'professionals')]
    #[ORM\JoinTable(name: 'professionals_specialities')]
    #[Groups(['pro_detail'])]
    private Collection $specialities;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): Professional
    {
        $this->place = $place;

        return $this;
    }

    public function getHours(): array
    {
        return $this->hours;
    }

    public function setHours(array $hours): Professional
    {
        $this->hours = $hours;

        return $this;
    }

    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function setSpecialities(Collection $specialities): Professional
    {
        $this->specialities = $specialities;

        return $this;
    }
}

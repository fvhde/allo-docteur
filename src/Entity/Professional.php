<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Hours\Hours;
use App\Entity\Professional\ProfessionalSpeciality;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Professional extends User
{
    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'professionals')]
    #[ORM\JoinColumn(name: 'place_id', referencedColumnName: 'id')]
    #[Groups(['pro_create', 'pro_detail'])]
    private ?Place $place = null;

    #[ORM\OneToOne(targetEntity: Hours::class, cascade: ['persist', 'remove'])]
    #[Groups(['pro_detail'])]
    private ?Hours $hours = null;

    #[ORM\OneToMany(mappedBy: 'professional', targetEntity: ProfessionalSpeciality::class)]
    #[Groups(['pro_detail'])]
    private Collection $specialities;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
        parent::__construct();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Professional
    {
        $this->description = $description;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): Professional
    {
        $this->place = $place;

        return $this;
    }

    public function getHours(): Hours
    {
        return $this->hours;
    }

    public function setHours(Hours $hours): Professional
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

    public function addSpeciality(ProfessionalSpeciality $s): Professional
    {
        if (!$this->specialities->contains($s)) {
            $this->specialities->add($s);
            $s->setProfessional($this);
        }

        return $this;
    }

    public function removeSpeciality(ProfessionalSpeciality $s): Professional
    {
        if ($this->specialities->contains($s)) {
            $this->specialities->remove($s);
            $s->setProfessional(null);
        }

        return $this;
    }
}

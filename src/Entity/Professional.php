<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Professional\ProfessionalSpeciality;
use App\Entity\ValueObject\OpeningHour;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Professional extends User
{
    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?string $avatar = null;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'professionals')]
    #[ORM\JoinColumn(name: 'place_id', referencedColumnName: 'id')]
    #[Groups(['pro_create', 'pro_detail'])]
    private ?Place $place = null;

    #[ORM\OneToMany(mappedBy: 'professional', targetEntity: OpeningHour::class, cascade: ['persist', 'remove'])]
    #[Groups(['pro_detail'])]
    private Collection $hours;

    #[ORM\OneToMany(mappedBy: 'professional', targetEntity: ProfessionalSpeciality::class, cascade: ['persist', 'remove'])]
    #[Groups(['pro_detail'])]
    private Collection $specialities;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
        $this->hours = new ArrayCollection();
        foreach (OpeningHour::DAYS as $day) {
            $this->hours->add((new OpeningHour())->setDay($day));
        }
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

    public function getHours(): Collection
    {
        return $this->hours;
    }


    public function addHour(OpeningHour $hour): Professional
    {
        if (!$this->hours->contains($hour)) {
            $this->hours->add($hour);
            $hour->setProfessional($this);
        }

        return $this;
    }

    public function setHours(Collection $hours): Professional
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

    public function getAvatar(): ?string
    {
        if (!$this->avatar) {
            return null;
        }
        if (strpos($this->avatar, '/') !== false) {
            return $this->avatar;
        }

        return sprintf('images/avatar/%s', $this->avatar);
    }

    public function setAvatar(?string $avatar): Professional
    {
        $this->avatar = $avatar;

        return $this;
    }
}

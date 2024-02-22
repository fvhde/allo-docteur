<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Timestamp\Timestampable;
use App\Entity\ValueObject\GeoPoint;
use App\Type\Doctrine\GeoPointType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Place
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['ap_create', 'pro_create', 'place_list', 'pro_detail'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['place_create', 'place_list', 'pro_detail', 'ap_list', 'ap_detail'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(['place_create', 'place_list', 'pro_detail', 'ap_detail'])]
    private string $phone;

    #[ORM\Column(type: GeoPointType::POINT)]
    #[Groups(['place_create', 'place_list', 'pro_detail', 'ap_detail'])]
    private GeoPoint $location;

    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Professional::class)]
    private Collection $professionals;

    public function __construct()
    {
        $this->location = new GeoPoint(0, 0);
        $this->professionals = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?string
    {
        return (string) $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Place
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Place
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLocation(): GeoPoint
    {
        return $this->location;
    }

    public function setLocation(GeoPoint $location): Place
    {
        $this->location = $location;

        return $this;
    }

    public function getProfessionals(): Collection
    {
        return $this->professionals;
    }

    public function setProfessionals(Collection $professionals): Place
    {
        $this->professionals = $professionals;

        return $this;
    }
}

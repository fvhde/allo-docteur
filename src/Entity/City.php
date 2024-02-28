<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\ValueObject\GeoPoint;
use App\Type\Doctrine\GeoPointType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity]
class City
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['ap_create', 'pro_create', 'place_list', 'pro_detail'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['place_create', 'place_list', 'pro_detail', 'ap_list', 'ap_detail'])]
    private string $name;


    #[ORM\Column(type: GeoPointType::POINT)]
    #[Groups(['place_create', 'place_list', 'pro_detail', 'ap_detail'])]
    private GeoPoint $location;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return City
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): City
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation(): GeoPoint
    {
        return $this->location;
    }

    public function setLocation(GeoPoint $location): City
    {
        $this->location = $location;
        return $this;
    }
}
<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Professional\ProfessionalSpeciality;
use App\Entity\Trait\Timestamp\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Speciality
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['ap_create', 'ap_detail'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['pro_detail', 'ap_detail'])]
    private string $name;

    #[ORM\Column(name: 'required_documents', type: 'json')]
    private array $requiredDocuments = [];

    #[ORM\OneToMany(mappedBy: 'speciality', targetEntity: ProfessionalSpeciality::class, cascade: ['persist', 'remove'])]
    private Collection $professionals;

    public function __construct()
    {
        $this->professionals = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Speciality
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

    public function setName(string $name): Speciality
    {
        $this->name = $name;

        return $this;
    }

    public function getRequiredDocuments(): array
    {
        return $this->requiredDocuments;
    }

    public function setRequiredDocuments(array $requiredDocuments): Speciality
    {
        $this->requiredDocuments = $requiredDocuments;

        return $this;
    }

    public function getProfessionals(): Collection
    {
        return $this->professionals;
    }

    public function setProfessionals(Collection $professionals): Speciality
    {
        $this->professionals = $professionals;

        return $this;
    }
}

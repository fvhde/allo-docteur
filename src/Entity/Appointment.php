<?php

namespace App\Entity;

use App\Entity\Enum\StatusEnum;
use App\Entity\Trait\Timestamp\Timestampable;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['ap_list', 'ap_detail'])]
    private null|string|Uuid $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_list', 'ap_detail'])]
    private \DateTimeInterface $beginAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_list', 'ap_detail'])]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Assert\Choice(callback: [StatusEnum::class, 'values'], groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_detail'])]
    private string $status;

    #[ORM\ManyToOne(targetEntity: Place::class)]
    #[ORM\JoinColumn(name: 'place_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_list', 'ap_detail'])]
    private ?Place $place = null;

    #[ORM\ManyToOne(targetEntity: Professional::class)]
    #[ORM\JoinColumn(name: 'professional_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_detail'])]
    private ?Professional $professional = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'patient_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_detail'])]
    private ?User $patient = null;

    #[ORM\ManyToOne(targetEntity: Speciality::class)]
    #[ORM\JoinColumn(name: 'speciality_id', referencedColumnName: 'id')]
    #[Groups(['ap_create', 'ap_detail'])]
    private ?Speciality $speciality = null;

    public function __construct()
    {
        $this->status = StatusEnum::CREATED->value;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): Appointment
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): Appointment
    {
        $this->place = $place;

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(Professional $professional): Appointment
    {
        $this->professional = $professional;

        return $this;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(User $patient): Appointment
    {
        $this->patient = $patient;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(Speciality $speciality): Appointment
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}

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
    private null|string|Uuid $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $date;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(groups: ['ap_create'])]
    #[Assert\Choice(callback: [StatusEnum::class, 'array'], groups: ['ap_create'])]
    #[Groups(['ap_create', 'ap_detail'])]
    private string $status;

    #[ORM\ManyToOne(targetEntity: Place::class)]
    #[ORM\JoinColumn(name: 'place_id', referencedColumnName: 'id')]
    private Place $place;

    #[ORM\ManyToOne(targetEntity: Professional::class)]
    #[ORM\JoinColumn(name: 'professional_id', referencedColumnName: 'id')]
    private Professional $professional;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(name: 'patient_id', referencedColumnName: 'id')]
    private Patient $patient;

    #[ORM\ManyToOne(targetEntity: Speciality::class)]
    #[ORM\JoinColumn(name: 'speciality_id', referencedColumnName: 'id')]
    private Speciality $speciality;

    public function getId(): null|string|Uuid
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): Appointment
    {
        $this->place = $place;

        return $this;
    }

    public function getProfessional(): Professional
    {
        return $this->professional;
    }

    public function setProfessional(Professional $professional): Appointment
    {
        $this->professional = $professional;

        return $this;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): Appointment
    {
        $this->patient = $patient;

        return $this;
    }

    public function getSpeciality(): Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(Speciality $speciality): Appointment
    {
        $this->speciality = $speciality;

        return $this;
    }
}

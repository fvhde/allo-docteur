<?php

declare(strict_types=1);

namespace App\Entity\Trait\Timestamp;

use App\Type\Doctrine\UTCDateTimeType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait Timestampable
{
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: UTCDateTimeType::TYPE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['default'])]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    protected ?string $createdAtTimezone;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: UTCDateTimeType::TYPE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['default'])]
    protected \DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    protected ?string $updatedAtTimezone;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAtTimezone = $createdAt->getTimezone()->getName();
        $this->createdAt = $createdAt->setTimezone(new \DateTimeZone('UTC'));

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAtTimezone = $updatedAt->getTimezone()->getName();
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}

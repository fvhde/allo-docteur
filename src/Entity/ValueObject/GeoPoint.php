<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Symfony\Component\Serializer\Annotation\Groups;

class GeoPoint
{
    #[Groups(['place_create', 'place_list', 'pro_detail'])]
    private float $latitude;
    #[Groups(['place_create', 'place_list', 'pro_detail'])]
    private float $longitude;

    public function __construct(
        float $latitude,
        float $longitude
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}

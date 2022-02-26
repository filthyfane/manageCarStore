<?php

namespace App\Entity;

use App\Entity\Traits\VehicleTrait;
use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    use VehicleTrait;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $pollutionCertificate;

    public function getPollutionCertificate(): ?string
    {
        return $this->pollutionCertificate;
    }

    public function setPollutionCertificate(string $pollutionCertificate): self
    {
        $this->pollutionCertificate = $pollutionCertificate;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\VehicleTrait;
use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    const POLL_CERT_A = "A";
    const POLL_CERT_B = "B";
    const POLL_CERT_C = "C";

    const POLL_CERTIFICATES = [
        self::POLL_CERT_A,
        self::POLL_CERT_B,
        self::POLL_CERT_C,
    ];

    use VehicleTrait;

    /**
     * @Assert\NotBlank(message="Pollution Certificate cannot be empty")
     * @Assert\Choice(
     *     choices=Truck::POLL_CERTIFICATES,
     *     message="Invalid pollution certificate. Valid options: A,B,C"
     * )
     * @ORM\Column(type="string", length=1, nullable=false)
     */
    private string $pollutionCertificate;

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

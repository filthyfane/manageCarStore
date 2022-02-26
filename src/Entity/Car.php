<?php

namespace App\Entity;

use App\Entity\Traits\VehicleTrait;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    use VehicleTrait;

    /**
     * @Assert\Positive(message="Passenger number must be a positive integer")
     * @Assert\NotNull(message="Passenger number cannot be empty")
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $passengerNo;

    public function getPassengerNo(): int
    {
        return $this->passengerNo;
    }

    public function setPassengerNo(int $passengerNo): self
    {
        $this->passengerNo = $passengerNo;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\VehicleTrait;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    use VehicleTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $passengerNo;

    public function getPassengerNo(): ?int
    {
        return $this->passengerNo;
    }

    public function setPassengerNo(int $passengerNo): self
    {
        $this->passengerNo = $passengerNo;

        return $this;
    }
}

<?php

namespace App\Entity\Traits;

use App\Repository\VehicleTraitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait VehicleTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank(message="Model name cannot be empty")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $model;

    /**
     * @Assert\NotBlank(message="Brand name cannot be empty")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $brand;

    /**
     * @Assert\Positive(message="Price field must be a positive decimal number")
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=false)
     */
    private float $price;

    /**
     * @Assert\Type(type="boolean", message="Sold status must be of type boolean")
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isSold = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsSold(): bool
    {
        return $this->isSold;
    }

    public function setIsSold(bool $isSold): self
    {
        $this->isSold = $isSold;

        return $this;
    }
}

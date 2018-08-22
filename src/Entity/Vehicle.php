<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    // Group api for nelmio and jms
    const API_GET  = 'api_method_get_vehicle';
    const API_POST = 'api_method_post_vehicle';
    const API_PUT  = 'api_method_put_vehicle';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $mileage;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $numberPlate;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $vehiculeCondition;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $nbDoors;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $nbSeets;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_POST, Vehicle::API_PUT})
     */
    private $indexPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="vehicles")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_PUT})
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_PUT})
     * 
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Rental::class, mappedBy="vehicle")
     *
     * @Serializer\Expose
     * @Serializer\Groups({Vehicle::API_GET, Vehicle::API_PUT})
     */
    private $rental;


    public function getId()
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getNumberPlate(): ?string
    {
        return $this->numberPlate;
    }

    public function setNumberPlate(string $numberPlate): self
    {
        $this->numberPlate = $numberPlate;

        return $this;
    }

    public function getVehiculeCondition(): ?string
    {
        return $this->vehiculeCondition;
    }

    public function setVehiculeCondition(string $vehiculeCondition): self
    {
        $this->vehiculeCondition = $vehiculeCondition;

        return $this;
    }

    public function getNbDoors(): ?int
    {
        return $this->nbDoors;
    }

    public function setNbDoors(int $nbDoors): self
    {
        $this->nbDoors = $nbDoors;

        return $this;
    }

    public function getNbSeets(): ?int
    {
        return $this->nbSeets;
    }

    public function setNbSeets(int $nbSeets): self
    {
        $this->nbSeets = $nbSeets;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndexPrice()
    {
        return $this->indexPrice;
    }

    /**
     * @param mixed $indexPrice
     */
    public function setIndexPrice($indexPrice): void
    {
        $this->indexPrice = $indexPrice;
    }

    /**
     * @return mixed
     */
    public function getRental()
    {
        return $this->rental;
    }
}

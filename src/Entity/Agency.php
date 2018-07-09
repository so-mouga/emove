<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postalCode;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, cascade={"persist", "remove"}, mappedBy="agency")
     */
    private $rentals;

    /**
     * @ORM\OneToMany(targetEntity=User::class, cascade={"persist", "remove"}, mappedBy="agency")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, cascade={"persist", "remove"}, mappedBy="agency")
     */
    private $vehicles;


    /**
     * Agency constructor.
     */
    public function __construct()
    {
        $this->rentals = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getRentals()
    {
        return $this->rentals;
    }

    public function addRentals(Rental $rental)
    {
        $this->rentals->add($rental);
        $rental->setAgency($this);
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function addAnswer(User $user)
    {
        $this->users->add($user);
        $user->setAgency($this);
    }

    public function getVehicles()
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles->add($vehicle);
        $vehicle->setAgency($this);
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }


}

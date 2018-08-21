<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency
{
    // Group api for nelmio and jms
    const API_GET  = 'api_method_get_user';
    const API_POST = 'api_method_post_user';
    const API_PUT  = 'api_method_put_user';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET})
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
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $postalCode;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, cascade={"persist", "remove"}, mappedBy="agency")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_PUT})
     */
    private $rentals;

    /**
     * @ORM\OneToMany(targetEntity=User::class, cascade={"persist", "remove"}, mappedBy="agency")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_PUT})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, cascade={"persist", "remove"}, mappedBy="agency")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
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

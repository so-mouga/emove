<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RentalRepository")
 */
class Rental
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $returnAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometerStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometerEnd;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agency;

    /**
     * @ORM\OneToOne(targetEntity=Vehicle::class, cascade={"persist", "remove"}, inversedBy="rental")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"}, inversedBy="rental")
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity=Penalty::class, cascade={"persist", "remove"}, mappedBy="rental")
     */
    private $penalties;

    public function __construct()
    {
        $this->penalties = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency): void
    {
        $this->agency = $agency;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKilometerStart(): int
    {
        return $this->kilometerStart;
    }

    /**
     * @param mixed $kilometerStart
     */
    public function setKilometerStart(int $kilometerStart): void
    {
        $this->kilometerStart = $kilometerStart;
    }

    /**
     * @return mixed
     */
    public function getKilometerEnd(): int
    {
        return $this->kilometerEnd;
    }

    /**
     * @param mixed $kilometerEnd
     */
    public function setKilometerEnd(int $kilometerEnd): void
    {
        $this->kilometerEnd = $kilometerEnd;
    }

    /**
     * @return mixed
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @return mixed
     */
    public function getPayment(): Payment
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment(Payment $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getReturnAt(): ?\DateTimeInterface
    {
        return $this->returnAt;
    }

    /**
     * @param mixed $returnAt
     */
    public function setReturnAt(\DateTimeInterface $returnAt): void
    {
        $this->returnAt = $returnAt;
    }

    public function getPenalties()
    {
        return $this->penalties;
    }

    public function addAnswer(Penalty $penalty)
    {
        $this->penalties->add($penalty);
        $penalty->setRental($this);
    }




}

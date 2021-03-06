<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PenaltyRepository")
 */
class Penalty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amout;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentary;

    /**
     * @ORM\ManyToOne(targetEntity=Rental::class, inversedBy="penalties")
     */
    private $rental;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class)
     */
    private $payment;


    public function getId()
    {
        return $this->id;
    }

    public function getAmout(): ?int
    {
        return $this->amout;
    }

    public function setAmout(int $amout): self
    {
        $this->amout = $amout;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRental(): Rental
    {
        return $this->rental;
    }

    /**
     * @param mixed $rental
     */
    public function setRental($rental): void
    {
        $this->rental = $rental;
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
}
